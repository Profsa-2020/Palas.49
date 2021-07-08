<?php
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

    $ema = retorna_dad('empemail', 'tb_empresa', 'idempresa', 1); 
    $_SESSION['wrkopcpro'] = retorna_dad('empproducao', 'tb_empresa', 'idempresa', 1); 
    if ($_SESSION['wrkopcpro']  == 0) {
        $_SESSION['wrkdadven']['tok_e'] = retorna_dad('emptokenhom', 'tb_empresa', 'idempresa', 1); 
    } else {
        $_SESSION['wrkdadven']['tok_e'] = retorna_dad('emptokenpro', 'tb_empresa', 'idempresa', 1); 
    }
    if ($_SESSION['wrkopcpro']  == 1) {
        if (strpos($ema,"milha") > 0) {
            $tok = '669a7edf-b932-49a2-bd9d-e8534729a680128017a443c095ca7cc829ee1077e9f71083-633d-460a-9ae4-79ac39ef5294';   // Afabb
        } else  {
            $tok = 'FF08EB437C2D4C22ABDF0E67822A0896';   // Produção - Profsa
        }
        if ($tip == "preApproval") {
            $url = 'https://ws.pagseguro.uol.com.br/pre-approvals/notifications/' . $cha . '?' . 'email=' . $ema . '&token=' . $tok;
        } else {
            $url = 'https://ws.pagseguro.uol.com.br/v3/transactions/notifications/' . $cha . '?' . 'email=' . $ema . '&token=' . $tok;
        }
    } else {
        if (strpos($ema,"milha") > 0) {
            $tok = '7CF6857560E0430A88629E6EB5B2EC09';   // Afabb
        } else {
            $tok = '99B1499ABF574D0583BEA5B2374EA103';   // Homologação - Profsa
        }
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
            } else if ($tip == "preApproval") {
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
            } else if ($tip == "transaction") {
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
    $key = explode('_', $dad['tit']['tit']);
    $sql = mysqli_query($conexao,"Select idassociado, assnome, asschave from tb_associado where idassociado = " . $key[2]);
    if (mysqli_num_rows($sql) == 1) {
        $lin = mysqli_fetch_array($sql);
        $cod = $lin['idassociado'];
        $nom = $lin['assnome'];
    } else if (mysqli_num_rows($sql) > 1) {
        $ret = gravar_log(58, substr("Erro: chave contém vários associados cadastrados: " . $dad['tit']['cod'] . " Data: " . $dad['tit']['dat'], 0, 500));
        return 6;

    }
    if ($cod == 0) {
        $ret = gravar_log(59, substr("Erro: chave não encontrada nos associados: " . $dad['tit']['cod'] . " Data: " . $dad['tit']['dat'], 0, 500));
        return 7;
    }
    $sql = mysqli_query($conexao,"Select idreceber from tb_receber where idassociado = " . $cod . " order by idreceber Limit 1");
    if (mysqli_num_rows($sql) == 1) {
        $lin = mysqli_fetch_array($sql);
        $cha = $lin['idreceber'];
    } else {
        $ret = gravar_log(60, substr("Erro: título não encontrada para associado: " . $dad['tit']['cod'] . " Data: " . $dad['tit']['dat'], 0, 500));
        return 8;
    }

    if ($cha != 0) {
        $sql  = "update tb_receber set ";
        if ($dad['tit']['sta'] == 3) { $sql .= "recstatus = '". '1' . "', "; }
        if ($dad['tit']['sta'] == 4) { $sql .= "recstatus = '". '1' . "', "; }
        if ($dad['tit']['sta'] == 5) { $sql .= "recstatus = '". '3' . "', "; }
        if ($dad['tit']['sta'] == 6) { $sql .= "recstatus = '". '5' . "', "; }
        if ($dad['tit']['sta'] == 7) { $sql .= "recstatus = '". '5' . "', "; }
        if ($dad['tit']['sta'] == 8) { $sql .= "recstatus = '". '4' . "', "; }
        if ($dad['tit']['sta'] == 9) { $sql .= "recstatus = '". '3' . "', "; }
        $sql .= "recdatapagto = '". substr($dad['tit']['dat'], 0, 19) . "', ";
        $sql .= "recvalpagto = '". $dad['tit']['val'] . "', ";
        $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
        $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
        $sql .= "where idreceber = " . $cha;
        $ret = mysqli_query($conexao,$sql);
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
    $sql  = "update tb_receber set ";
    $sql .= "recstatus = '". ($dad['tit']['sta'] == "CANCELLED_BY_RECEIVER" ? '4' : '5') . "', "; 
    $sql .= "recdatapagto = '". substr($dad['tit']['dat'], 0, 19) . "', ";
    if ($dad['tit']['sta'] == "CANCELLED_BY_RECEIVER") {
        $sql .= "recobservacao = '". 'CANCELAMENTO DE ASSINATURA PELA AFABB EM ' . date('d/m/Y H:i:s') . "', "; 
    } else {
        $sql .= "recobservacao = '". 'CANCELAMENTO DE ASSINATURA PELO ASSOCIADO EM ' . date('d/m/Y H:i:s') . "', "; 
    }
    $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
    $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
    $sql .= "where recstatus = 0 and idassociado = " . (int) $key[2];
    $ret = mysqli_query($conexao,$sql);
    if ($ret == true) {
        $ret = gravar_log(63, substr("Atualização do cancelamento: " . $cha . " Nome: " . $dad['ass']['nom'] . " Status: " . $dad['tit']['sta'], 0, 500));
    } else {
        $ret = gravar_log(64, substr("Erro: cancelamentos de títulos: " . $cha . " Sql: " . $sql, 0, 500));
        $sta = 12;
    }   

    return $sta;
}

?>