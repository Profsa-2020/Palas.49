<?php

     // header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");

    $sta = 00;
    $dad = array();
    session_start();
    include_once "dados.php";
    include_once "profsa.php";
   $_SESSION['wrknompro'] = __FILE__;
    date_default_timezone_set("America/Sao_Paulo");
    if (isset($_SESSION['wrkideusu']) == false) { $_SESSION['wrkideusu'] = 0; }
    if (isset($_SESSION['wrkopcpro']) == false) { $_SESSION['wrkopcpro'] = 0; }

    $cha = (isset($_REQUEST['notificationCode']) == false ? '' : $_REQUEST['notificationCode']);
    $tip = (isset($_REQUEST['notificationType']) == false ? '' : $_REQUEST['notificationType']);
    $dad['tit']['key'] = (isset($_REQUEST['notificationCode']) == false ? '' : $_REQUEST['notificationCode']);

    $ema = retorna_dad('empemail', 'tb_empresa', 'idempresa', 1); 
    $_SESSION['wrkopcpro'] = retorna_dad('emptipo', 'tb_empresa', 'idempresa', 1); 
    if ($_SESSION['wrkopcpro']  == 0) {
        $_SESSION['wrkdadven']['tok_e'] = retorna_dad('emptokenhom', 'tb_empresa', 'idempresa', 1); $tok = $_SESSION['wrkdadven']['tok_e'];
    } else {
        $_SESSION['wrkdadven']['tok_e'] = retorna_dad('emptokenpro', 'tb_empresa', 'idempresa', 1); $tok = $_SESSION['wrkdadven']['tok_e'];
    }
    if ($_SESSION['wrkopcpro']  == 1) {
        if ($tip == "preApproval") {
            $url = 'https://ws.pagseguro.uol.com.br/pre-approvals/notifications/' . $cha . '?' . 'email=' . $ema . '&token=' . $tok;
        } else {
            $url = 'https://ws.pagseguro.uol.com.br/v3/transactions/notifications/' . $cha . '?' . 'email=' . $ema . '&token=' . $tok;
        }
    } else {
        if ($tip == "preApproval") {
            $url = 'https://ws.sandbox.pagseguro.uol.com.br/pre-approvals/notifications/' . $cha . '?' . 'email=' . $ema . '&token=' . $tok;

        } else {
            $url = 'https://ws.sandbox.pagseguro.uol.com.br/v3/transactions/notifications/' . $cha . '?' . 'email=' . $ema . '&token=' . $tok;
        }
    }

    if ($cha == "") {
        $ret = gravar_log(50, "Informações de notificação vinda do PagSeguro estão em branco");
        $sta = 1;
    }else{
        
        $cur = curl_init($url);
        if ($tip == "preApproval") {
            curl_setopt($cur, CURLOPT_HTTPHEADER, array('Content-Type: application/xml', 'Accept: application/vnd.pagseguro.com.br.v3+xml;charset=ISO-8859-1'));
        }
        curl_setopt($cur, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cur, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($cur, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        $xml = curl_exec($cur); $vol = $xml;

        if (file_exists('ret') == false) { mkdir('ret'); }
        $dir = __DIR__;
        $cam =  'ret' . '/' . 'Ret-' .  date('d-m-Y.H-i-s'). '.xml';
        $fil = fopen($cam, 'w');
        fwrite($fil, $xml);
        fclose($fil);      

        curl_close($cur);
        
        if ($xml == 'Unauthorized' || $xml == false) { 
            $ret = gravar_log(51, "Informações para notificar do PagSeguro não estão corretas: " . $ema);
            $sta = 2;
        } else if ($xml == 'Not Found' || $xml == false) { 
                $ret = gravar_log(52, "Chave de acesso lida do PagSeguro não existe para a API: " . $cha . ' - Tipo:' . $tip);
                $sta = 3;
        } else {
            // $ret = gravar_log(53, substr("Processamento de Notificação Código: " . $cha  . " Tip: " . $tip . " Ema: " . $ema . " Xml: " . $vol, 0, 500)); //
            $xml = simplexml_load_string($xml);
            if (isset($xml->error) == true) {
                $sta = 4;
                $cha = (string) $xml->error->code;
                $men = (string) $xml->error->message;
                $ret = gravar_log(54, substr("Erro: " . $cha . "-" . $men . " Xml: " . $vol, 0, 500));
            } else if ($tip == "preApproval") { // Notificação enviada quando feita assinatura.
                $sta = 5; $ret = 0;
                $dad['tit']['cod'] = (string) $xml->code;
                $dad['tit']['dat'] = (string) $xml->date;
                $dad['tit']['sta'] = (string) $xml->status;
                $dad['tit']['tit'] = (string) $xml->reference;
                $dad['ass']['nom'] = (string) $xml->sender->name;
                $dad['ass']['ema'] = (string) $xml->sender->email;
                $dad['ass']['ddd'] = (string) $xml->sender->phone->areaCode;
                $dad['ass']['fon'] = (string) $xml->sender->phone->number;
                $dad['tit']['eve'] = (string) $xml->lastEventDate;
                $ret = gravar_log(54, substr("Assinatura: " . $cha . " Tip: " . $tip  . " Ref: " . $dad['tit']['tit'] . " Xml: " . $vol, 0, 500));
                if ($dad['tit']['sta'] == "CANCELLED") {
                    $sta = atualiza_can($dad);
                    $ret = gravar_log(55, substr("Cancelamento Associado: " . $cha . " Tip: " . $tip  . " Ref: " . $dad['tit']['tit'] . " Xml: " . $vol, 0, 500));
                } else if ($dad['tit']['sta'] == "CANCELLED_BY_RECEIVER") {
                    $sta = atualiza_can($dad);
                    $ret = gravar_log(55, substr("Cancelamento pela Afabb: " . $cha . " Tip: " . $tip  . " Ref: " . $dad['tit']['tit'] . " Xml: " . $vol, 0, 500));
                } else {
                    $ret = gravar_log(56, substr("Assinatura: " . $cha . " Tip: " . $tip  . " Ref: " . $dad['tit']['tit'] . " Xml: " . $vol, 0, 500));
                }
            } else if ($tip == "transaction") { // Notificação enviada quando muda o status
                $sta = 6; $ret = 0;
                $dad['tit']['cod'] = (string) $xml->code;
                $dad['tit']['dat'] = (string) $xml->date;
                $dad['tit']['tit'] = (string) $xml->reference;
                $dad['tit']['sta'] = (string) $xml->status;
                $dad['tit']['bru'] = (string) $xml->grossAmount;
                $dad['tit']['val'] = (string) $xml->netAmount;
                $dad['tit']['eve'] = (string) $xml->lastEventDate;
                $dad['ass']['nom'] = (string) $xml->sender->name;
                $dad['ass']['ema'] = (string) $xml->sender->email;
                $dad['ass']['ddd'] = (string) $xml->sender->phone->areaCode;
                $dad['ass']['fon'] = (string) $xml->sender->phone->number;
                $dad['pag']['tip'] = (string) $xml->paymentMethod->type;
                $dad['pag']['cod'] = (string) $xml->paymentMethod->code;
                $dad['pag']['liq'] = (string) $xml->netAmount;
                $dad['pag']['ds1'] = (string) $xml->creditorFees->installmentFeeAmount;
                $dad['pag']['ds2'] = (string) $xml->creditorFees->intermediationRateAmount;
                $dad['pag']['ds3'] = (string) $xml->creditorFees->intermediationFeeAmount;
                $dad['gat']['tip'] = (string) $xml->gatewaySystem->type;
                $dad['gat']['cod'] = (string) $xml->gatewaySystem->establishmentCode;
                $dad['gat']['nom'] = (string) $xml->gatewaySystem->acquirerName;
                $ret = gravar_log(57, substr("Notificação: " . $cha . " Tip: " . $tip  . " Ref: " . $dad['tit']['tit'] . " Xml: " . $vol, 0, 500));
                $sta = atualiza_tit($dad);
                /*
                Codigo	Significado
                1	Aguardando pagamento: o comprador iniciou a transação, mas até o momento o PagSeguro não recebeu nenhuma informação sobre o pagamento.
                2	Em análise: o comprador optou por pagar com um cartão de crédito e o PagSeguro está analisando o risco da transação.
                3	Paga: a transação foi paga pelo comprador e o PagSeguro já recebeu uma confirmação da instituição financeira responsável pelo processamento.
                4	Disponível: a transação foi paga e chegou ao final de seu prazo de liberação sem ter sido retornada e sem que haja nenhuma disputa aberta.
                5	Em disputa: o comprador, dentro do prazo de liberação da transação, abriu uma disputa.
                6	Devolvida: o valor da transação foi devolvido para o comprador.
                7	Cancelada: a transação foi cancelada sem ter sido finalizada.
                8	Debitado: o valor da transação foi devolvido para o comprador.
                9	Retenção temporária: o comprador abriu uma solicitação de chargeback junto à operadora do cartão de crédito.            
                */
                
            }
        }
    }
    echo "Status: " . $sta . " Data: " . date('d/m/Y H:i:s');

function atualiza_tit($dad) {
    $sta = 10;
    $cod = 0;    
    $cha = 0;
    $nom = '';
    include_once "dados.php";
    $key = explode('_', $dad['tit']['tit']); // 0-Ref 1-Plano 2-Cliente 3-Cpf 
    $nro = acessa_reg("Select idsenha, usunome from tb_usuario where idsenha = " . $key[2], $reg);            
    if ($nro == 1) {
        $cod = $reg['idsenha'];
        $nom = $reg['usunome'];
    }
    if ($nro > 1) {
        $ret = gravar_log(58, substr("Erro: chave contém vários contratantes cadastrados: " . $dad['tit']['cod'] . " Data: " . $dad['tit']['dat'], 0, 500));
        return 6;
    }
    if ($cod == 0) {
        $ret = gravar_log(59, substr("Erro: chave não encontrada nos contratantes: " . $dad['tit']['cod'] . " Data: " . $dad['tit']['dat'], 0, 500));
        return 7;
    }
    $nro = acessa_reg("Select idtitulo, titadministrador from tb_titulo where titchave = '" . $dad['tit']['key'] . "'", $reg);            
    if ($nro == 1) {
        $cha = $reg['idtitulo'];
    } else if ($nro == 0) {
        $ret = gravar_log(60, substr("Erro: título não encontrada para contratante: " . $dad['tit']['cod'] . " Data: " . $dad['tit']['dat'], 0, 500));
        return 8;
    }

    if ($cha != 0) {
        $sql  = "update tb_titulo set ";    // 0-aberto 1-pago 2-cancelado 3-cortesia 4-suspenso
        if ($dad['tit']['sta'] == 3) { $sql .= "titstatus = '". '1' . "', "; }
        if ($dad['tit']['sta'] == 4) { $sql .= "titstatus = '". '1' . "', "; }
        if ($dad['tit']['sta'] == 5) { $sql .= "titstatus = '". '4' . "', "; }
        if ($dad['tit']['sta'] == 6) { $sql .= "titstatus = '". '2' . "', "; }
        if ($dad['tit']['sta'] == 7) { $sql .= "titstatus = '". '2' . "', "; }
        if ($dad['tit']['sta'] == 8) { $sql .= "titstatus = '". '4' . "', "; }
        if ($dad['tit']['sta'] == 9) { $sql .= "titstatus = '". '4' . "', "; }
        $sql .= "titdatabai = '". substr($dad['tit']['dat'], 0, 19) . "', ";
        $sql .= "titpago = '". $dad['tit']['val'] . "', ";
        $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
        $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
        $sql .= "where idtitulo = " . $cha;
        $ret = comando_tab($sql, $nro, $ult, $men);
        if ($ret == true) {
            $ret = gravar_log(61, substr("Atualização do título: " . $cha . " Nome: " . $dad['ass']['nom'] . " Status: " . $dad['tit']['sta'], 0, 500));
        } else {
            $ret = gravar_log(62, substr("Erro: atualização do título: " . $cha . " Sql: " . $sql, 0, 500));
            $sta = 9;
        }   
    }
    return $sta;
}

function atualiza_can($dad) {
    $sta = 12;
    $cod = 0;    
    $cha = 0;
    $nom = '';
    include_once "dados.php";
    $key = explode('_', $dad['tit']['tit']);
    $sql  = "update tb_titulo set ";
    $sql .= "titstatus = '". ($dad['tit']['sta'] == "CANCELLED_BY_RECEIVER" ? '4' : '2') . "', "; 
    $sql .= "titpago = '". substr($dad['tit']['dat'], 0, 19) . "', ";
    if ($dad['tit']['sta'] == "CANCELLED_BY_RECEIVER") {
        $sql .= "titobservacao = '". 'CANCELAMENTO DE ASSINATURA PELA ADMMILHAS EM ' . date('d/m/Y H:i:s') . "', "; 
    } else {
        $sql .= "titobservacao = '". 'CANCELAMENTO DE ASSINATURA PELO CONTRATANTE EM ' . date('d/m/Y H:i:s') . "', "; 
    }
    $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
    $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
    $sql .= "where titstatus = 0 and titchave = '" . $dad['tit']['cod'] . "'";
    $ret = comando_tab($sql, $nro, $ult, $men);
    if ($ret == true) {
        $ret = gravar_log(63, substr("Atualização do cancelamento: " . $cha . " Nome: " . $dad['ass']['nom'] . " Status: " . $dad['tit']['sta'], 0, 500));
    } else {
        $ret = gravar_log(64, substr("Erro: cancelamentos de títulos: " . $cha . " Sql: " . $sql, 0, 500));
        $sta = 12;
    }   

    return $sta;
}

?>