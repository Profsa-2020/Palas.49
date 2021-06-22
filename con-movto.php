<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt_br">

<head>
     <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
     <meta name="description" content="Profsa Informática - Gerenciamento de Milhas - Alexandre Alves Rautemberg" />
     <meta name="author" content="Paulo Rogério Souza" />
     <meta name="viewport" content="width=device-width, initial-scale=1" />

     <link href="https://fonts.googleapis.com/css?family=Lato:300,400" rel="stylesheet" type="text/css" />
     <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet" type="text/css" />

     <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css">

     <link rel="icon" href="https://www.admmilhas.com.br/pallas49/img/logo-11.png" sizes="32x32" />
     <link rel="icon" href="https://www.admmilhas.com.br/pallas49/img/logo-12.png" sizes="50x50" />
     <link rel="icon" href="https://www.admmilhas.com.br/pallas49/img/logo-13.png" sizes="192x192" />
     <link rel="apple-touch-icon" href="https://www.admmilhas.com.br/pallas49/img/logo-14.png" />

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
          integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
     </script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
          integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
     </script>

     <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
     <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

     <script type="text/javascript" language="javascript"
          src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
     <link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />

     <script type="text/javascript" src="js/jquery.mask.min.js"></script>

     <script type="text/javascript" src="js/datepicker-pt-BR.js"></script>

     <link href="css/pallas49.css" rel="stylesheet" type="text/css" media="screen" />
     <title>Consultas - Gerenciamento de Milhas - Alexandre Rautemberg - Profsa Informátda Ltda</title>
</head>

<script>
$(function() {
     $("#dti").mask("99/99/9999");
     $("#dtf").mask("99/99/9999");
     $("#dti").datepicker($.datepicker.regional["pt-BR"]);
     $("#dtf").datepicker($.datepicker.regional["pt-BR"]);
});

$(document).ready(function() {
     $('#ope').change(function() {
          $('#tab-0 tbody').empty();
     });

     $('#usu').change(function() {
          $('#tab-0 tbody').empty();
          let usu = $('#usu').val();
          $.get( "ajax/carrega-pro.php", { usu: usu })
               .done(function(data) {
                    $('#pro').empty().html(data);
               });
     });

     $('#pro').change(function() {
          $('#tab-0 tbody').empty();
     });

     $('#dti').change(function() {
          $('#tab-0 tbody').empty();
     });

     $('#dtf').change(function() {
          $('#tab-0 tbody').empty();
     });

     $('.baixa').click(function() {
          let cod = $(this).attr("cod");
          let ope = $(this).attr("ope");
          $("#sta_m").val(ope);
          if (ope == 1) {
               $('#tel-mov').text("Baixa de Bônus Recebido (Transferência)");
          } else {
               $('#tel-mov').text("Baixa de Valor Recebido (Venda)");
          }
          $.getJSON("ajax/carrega-mov.php", {
                    ope: ope, cod: cod })
               .done(function(data) {
                    if (data.men != "") {
                         alert(data.men);
                    } else {
                         $('#dad_mov').html(data.txt);
                    }
               }).fail(function(data) {
                    console.log('Erro: ' + JSON.stringify(data));
                    alert("Erro ocorrido no processamento do movimento solicitado");
               });
          $('#bai-mov').modal('show');
     });

     $('#gra_m').click(function() {
          let opc = $("#sta_m").val();
          $.getJSON("ajax/gravar-bai.php", {
                    opc: opc })
               .done(function(data) {
                    if (data.men != "") {
                         alert(data.men);
                    } else {
                         $('#frmTelCon').submit();
                    }
               }).fail(function(data) {
                    console.log('Erro: ' + JSON.stringify(data));
                    alert("Erro ocorrido na gravação do movimento solicitado");
               });
     });

     $('#tab-0').DataTable({
          "pageLength": 25,
          "aaSorting": [
               [2, 'desc'],
               [1, 'asc'],
               [3, 'asc']
          ],
          "language": {
               "lengthMenu": "Demonstrar _MENU_ linhas por páginas",
               "zeroRecords": "Não existe registros a demonstar ...",
               "info": "Mostrada página _PAGE_ de _PAGES_",
               "infoEmpty": "Sem registros de Movimento ...",
               "sSearch": "Buscar:",
               "infoFiltered": "(Consulta de _MAX_ total de linhas)",
               "oPaginate": {
                    sFirst: "Primeiro",
                    sLast: "Último",
                    sNext: "Próximo",
                    sPrevious: "Anterior"
               }
          }
     });

     $(window).scroll(function() {
          if ($(this).scrollTop() > 100) {
               $(".subir").fadeIn(500);
          } else {
               $(".subir").fadeOut(250);
          }
     });

     $(".subir").click(function() {
          $topo = $("#box00").offset().top;
          $('html, body').animate({
               scrollTop: $topo
          }, 1500);
     });

});
</script>

<?php
     $ret = 00;
     include_once "dados.php";
     include_once "profsa.php";
     $_SESSION['wrknompro'] = __FILE__;
     date_default_timezone_set("America/Sao_Paulo");
     $dti = date('d/m/Y', strtotime('-29 days'));
     $dtf = date('d/m/Y', strtotime('+5 days'));
     $usu = (isset($_REQUEST['usu']) == false ? 0 : $_REQUEST['usu']);
     $pro = (isset($_REQUEST['pro']) == false ? 0 : $_REQUEST['pro']);
     $dti = (isset($_REQUEST['dti']) == false ? $dti : $_REQUEST['dti']);
     $dtf = (isset($_REQUEST['dtf']) == false ? $dtf : $_REQUEST['dtf']);
     if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrknomant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(10,"Entrada na página de Consulta de Movimento no sistema: " . $dti . " até " . $dtf);  
          }
     }
     $ope = (isset($_REQUEST['ope']) == false ? 0 : $_REQUEST['ope']);

?>

<body id="box00">
     <h1 class="cab-0">Consulta de Movto - Gerenciamento de Pontos e Milhas - Profsa Informática</h1>
     <?php include_once "cabecalho-1.php"; ?>
     <div class="container-fluid">
          <div class="row">
               <div class="col-md-12">
                    <div class="container">
                         <form class="qua-2" id="frmTelCon" name="frmTelCon" action="" method="POST">
                              <p class="lit-4">Consulta de Movimentos</p><br />
                              <div class="row">
                                   <div class="col-md-2">
                                        <label>Operação</label><br />
                                        <select id="ope" name="ope" class="form-control">
                                             <option value="0" <?php echo ($ope != 0 ? '' : 'selected="selected"'); ?>>
                                                  Todas
                                             </option>
                                             <option value="1" <?php echo ($ope != 1 ? '' : 'selected="selected"'); ?>>
                                                  Compra
                                             </option>
                                             <option value="2" <?php echo ($ope != 2 ? '' : 'selected="selected"'); ?>>
                                                  Transferência
                                             </option>
                                             <option value="3" <?php echo ($ope != 3 ? '' : 'selected="selected"'); ?>>
                                                  Venda
                                             </option>
                                             <option value="4" <?php echo ($ope != 4 ? '' : 'selected="selected"'); ?>>
                                                  Passagem
                                             </option>
                                             <option value="5" <?php echo ($ope != 5 ? '' : 'selected="selected"'); ?>>
                                                  Cartão
                                             </option>
                                        </select>
                                   </div>
                                   <div class="col-md-3">
                                        <label>Usuário</label>
                                        <select id="usu" name="usu" class="form-control">
                                             <?php $ret = carrega_usu($usu); ?>
                                        </select>
                                   </div>
                                   <div class="col-md-2">
                                        <label>Programa</label>
                                        <select id="pro" name="pro" class="form-control">
                                             <?php $ret = carrega_pro($pro); ?>
                                        </select>
                                   </div>
                                   <div class="col-md-2">
                                        <label>Data Inicial</label>
                                        <input type="text" class="form-control text-center" maxlength="10" id="dti"
                                             name="dti" value="<?php echo $dti; ?>" required />
                                   </div>
                                   <div class="col-md-2">
                                        <label>Data Final</label>
                                        <input type="text" class="form-control text-center" maxlength="10" id="dtf"
                                             name="dtf" value="<?php echo $dtf; ?>" required />
                                   </div>
                                   <div class="col-md-1 text-center">
                                        <br />
                                        <button type="submit" id="con" name="consulta" class="bot-2"
                                             title="Carrega ocorrências conforme periodo solicitado pelo usuário."><i
                                                  class="fa fa-search fa-2x" aria-hidden="true"></i></button>
                                   </div>
                              </div>
                              <br />
                         </form>
                         <br />
                    </div>
                    <div class="container-fluid">
                         <div class="row">
                              <div class="tab-1 table-responsive">
                                   <table id="tab-0" class="table table-sm table-striped">
                                        <thead>
                                             <tr>
                                                  <th>Baixar</th>
                                                  <th>Operação</th>
                                                  <th>Id</th>
                                                  <th>Usuário</th>
                                                  <th>Programa</th>
                                                  <th>Data</th>
                                                  <th>Quantidade</th>
                                                  <th>Preço</th>
                                                  <th>Valor</th>
                                                  <th>Intermediário</th>
                                                  <th>Receber</th>
                                                  <th>Localizador</th>
                                                  <th class="text-center">CPF</th>
                                                  <th>Promoção</th>
                                                  <th>Destino</th>
                                                  <th>% de Bônus</th>
                                                  <th>% Volta</th>
                                                  <th>Observação para a Operação</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <?php $ret = carrega_mov($ope, $usu, $pro, $dti, $dtf);  ?>
                                        </tbody>
                                   </table>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>

     <!-------------------------------------------------------------------------------------------------------------------------->
     <div class="modal fade" id="bai-mov" tabindex="-1" role="dialog" aria-labelledby="tel-mov" aria-hidden="true"
          data-backdrop="static">
          <div class="modal-dialog modal-lg" role="document">
               <!-- modal-sm modal-lg modal-xl -->
               <form id="frmMosMov" name="frmMosMov" action="con-movto.php" method="POST">
                    <div class="modal-content">
                         <div class="modal-header bg-primary text-white">
                              <h5 class="modal-title" id="tel-mov">Baixa de Movimento</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                   <span aria-hidden="true">&times;</span>
                              </button>
                         </div>
                         <div class="modal-body">
                              <div class="row">
                                   <div class="col-md-12 text-center">
                                        <div id="dad_mov"></div>
                                   </div>
                              </div>
                              <br />
                         </div>
                         <div class="modal-footer">
                              <button type="button" id="gra_m" name="salvar"
                                   class="btn btn-outline-success">Baixar</button>
                              <button type="button" id="fec_m" name="fec_m" class="btn btn-outline-danger"
                                   data-dismiss="modal">Fechar</button>
                         </div>
                    </div>
                    <input type="hidden" id="sta_m" name="sta_m" value="0" />
               </form>
          </div>
     </div>
     <!------------------------------------------------------------------------------------------------------------------------>

     <div id="box10">
          <img class="subir" src="img/subir.png" title="Volta a página para o seu topo." />
     </div>
</body>

<?php 
function carrega_usu($usu) {
     $sta = 0;
     include_once "dados.php";    
     echo '<option value="0" selected="selected">Selecione ...</option>';
     $com = "Select idsenha, usunome from tb_usuario where usustatus = 0 and usuempresa = " . $_SESSION['wrkcodemp'] . " order by usunome, idsenha";
     $nro = leitura_reg($com, $reg);
     foreach ($reg as $lin) {
          if ($lin['idsenha'] != $usu) {
               echo  '<option value ="' . $lin['idsenha'] . '">' . $lin['usunome'] . '</option>'; 
          } else {
               echo  '<option value ="' . $lin['idsenha'] . '" selected="selected">' . $lin['usunome'] . '</option>';
          }
     }
     return $sta;
}

function carrega_pro($pro) {
     $sta = 0;
     include_once "dados.php";    
     echo '<option value="0" selected="selected">Selecione ...</option>';
     $com = "Select idprograma, prodescricao from tb_programa where prostatus = 0 and proempresa = " . $_SESSION['wrkcodemp'] . " order by prodescricao, idprograma";
     $nro = leitura_reg($com, $reg);
     foreach ($reg as $lin) {
          if ($lin['idprograma'] != $pro) {
               echo  '<option value ="' . $lin['idprograma'] . '">' . $lin['prodescricao'] . '</option>'; 
          } else {
               echo  '<option value ="' . $lin['idprograma'] . '" selected="selected">' . $lin['prodescricao'] . '</option>';
          }
     }
     return $sta;
}

function carrega_mov($ope, $usu, $pro, $dti, $dtf) {
     $nro = 0; $com = "";
     include_once "dados.php";
     $dti = substr($dti,6,4) . "-" . substr($dti,3,2) . "-" . substr($dti,0,2);
     $dtf = substr($dtf,6,4) . "-" . substr($dtf,3,2) . "-" . substr($dtf,0,2);
     $com .= "Select M.*, U.usunome, P.prodescricao, I.intdescricao, X.cardescricao from (((((tb_movto M left join tb_conta C on M.movconta = C.idconta) ";
     $com .= "left join tb_usuario U on M.movusuario = U.idsenha) ";
     $com .= "left join tb_programa P on M.movprograma = P.idprograma) ";
     $com .= "left join tb_intermediario I on M.movintermediario = I.idintermediario) ";
     $com .= "left join tb_cartao X on M.movcartao = X.idcartao) ";
     $com .= "where movempresa = " . $_SESSION['wrkcodemp'] . " and movdata between '" . $dti . "' and '" . $dtf . "' ";
     if ($ope != 0) { $com .=" and movstatus = " . $ope; }
     if ($usu != 0) { $com .=" and movusuario = " . $usu; }
     if ($pro != 0) { $com .=" and movprograma = " . $pro; }
     $com .= " order by idmovto desc";          
     $nro = leitura_reg($com, $lin);
     foreach ($lin as $reg) {       
          $txt =  '<tr>';
          if ($reg['movtipo'] == 2 || $reg['movtipo'] == 3 || $reg['movtipo'] == 4 || $reg['movtipo'] == 8 || $reg['movtipo'] == 9) {
               if ($reg['movliquidado'] == 0 && $reg['movbonus'] < date('Y-m-d')) {
                    $txt =  '<tr class="cor-1">';
               }
          }
          if ($reg['movtipo'] == 5) {
               if ($reg['movliquidado'] == 0 && $reg['movvecto'] < date('Y-m-d')) {
                    $txt =  '<tr class="cor-1">';
               }
          }
          if ($reg['movtipo'] == 0 || $reg['movtipo'] == 1 || $reg['movtipo'] == 6) {
               $txt .= '<td class="text-center"></td>';
          }
          if ($reg['movtipo'] == 2 || $reg['movtipo'] == 3 || $reg['movtipo'] == 4 || $reg['movtipo'] == 7 || $reg['movtipo'] == 8) {
               if ($reg['movliquidado'] == 1) {
                    $txt .= '<td class="text-center"><i class="fa fa-check-square-o fa-2x" aria-hidden="true"></i></td>';
               } else { 
                    $txt .= '<td class="text-center"><a class="cur-1 baixa" href="#" ope=' . $reg['movtipo']. ' cod=' . $reg['idmovto'] . ' title="Efetua baixa de quantidade ou valor recebido do movimento informado na linha ..."><i class="fa fa-check-square-o fa-2x" aria-hidden="true"></i></a></td>';
               }
          }
          if ($reg['movtipo'] == 5) {
               if ($reg['movliquidado'] == 1) {
                    $txt .= '<td class="text-center"><i class="fa fa-money fa-2x" aria-hidden="true"></i></td>';
               } else { 
                    $txt .= '<td class="text-center"><a class="cur-1 baixa" href="#" ope=' . $reg['movtipo']. ' cod=' . $reg['idmovto'] . ' title="Efetua baixa de quantidade ou valor recebido do movimento informado na linha ..."><i class="fa fa-money fa-2x" aria-hidden="true"></i></a></td>';
               }
          }
          if ($reg['movtipo'] == 0) {$txt .= "<td>" . "Compra(+)" . "</td>";}
          if ($reg['movtipo'] == 1) {$txt .= "<td>" . "Transfer (-)" . "</td>";}
          if ($reg['movtipo'] == 2) {$txt .= "<td>" . "Transfer (+)" . "</td>";}
          if ($reg['movtipo'] == 3) {$txt .= "<td>" . "Bônus (+)" . "</td>";}
          if ($reg['movtipo'] == 4) {$txt .= "<td>" . "Bônus (+)" . "</td>";}
          if ($reg['movtipo'] == 5) {$txt .= "<td>" . "Venda (-)" . "</td>";} 
          if ($reg['movtipo'] == 6) {$txt .= "<td>" . "Passagem (-)" . "</td>";} 
          if ($reg['movtipo'] == 7) {$txt .= "<td>" . "Cartão (+)" . "</td>";} 
          if ($reg['movtipo'] == 8) {$txt .= "<td>" . "Bônus [+]" . "</td>";} 
          $txt .= '<td class="text-center">' . $reg['idmovto'] . '</td>';
          $txt .= '<td>' . $reg['usunome'] . '</td>';
          $txt .= '<td>' . $reg['prodescricao'] . '</td>';
          $txt .= '<td>' . date('d/m/Y',strtotime($reg['movdata'])) . '</td>';
          $txt .= '<td class="text-right">' . number_format($reg['movquantidade'], 0, ",", ".") . '</td>';
          if ($reg['movtipo'] == 2 || $reg['movtipo'] == 7 || $reg['movtipo'] == 8) {
               $txt .= '<td class="text-right">' . number_format($reg['movcusto'], 2, ",", ".") . '</td>';
               $txt .= '<td class="text-right">' . number_format($reg['movcusto'] * $reg['movquantidade'] / 1000, 2, ",", ".") . '</td>';
          } else {
               $txt .= '<td class="text-right">' . number_format($reg['movvalor'] / $reg['movquantidade'] * 1000, 2, ",", ".") . '</td>';
               $txt .= '<td class="text-right">' . number_format($reg['movvalor'], 2, ",", ".") . '</td>';
          }
          $txt .= '<td>' . $reg['intdescricao'] . '</td>';
          if ($reg['movvecto'] == null) {
               if ($reg['movbonus'] == null) {
                    $txt .= '<td>' . '' . '</td>';
               } else {
                    $txt .= '<td>' . date('d/m/Y',strtotime($reg['movbonus'])) . '</td>';
               }
          } else {
               $txt .= '<td>' . date('d/m/Y',strtotime($reg['movvecto'])) . '</td>';
          }
          $txt .= '<td>' . $reg['movlocalizador'] . '</td>';
          $txt .= '<td class="text-center">' . $reg['movnumerocpf'] . '</td>';
          if ($reg['movpromocao'] == 0) {$txt .= '<td>' . "" . '</td>';}
          if ($reg['movpromocao'] == 1) {$txt .= '<td class="text-center">' . "Comum" . '</td>';}
          if ($reg['movpromocao'] == 2) {$txt .= '<td class="text-center">' . "Bumerangue" . '</td>';}
          if ($reg['movpromocao'] == 3) {$txt .= '<td class="text-center">' . "Transferência" . '</td>';}
          if ($reg['movpromocao'] == 4) {$txt .= '<td class="text-center">' . "Transferência" . '</td>';}
          $cod = retorna_dad('conprograma', 'tb_conta', 'idconta', $reg['movdestino']); 
          $des = retorna_dad('prodescricao', 'tb_programa', 'idprograma', $cod); 
          $txt .= '<td>' . $des . '</td>';
          if ($reg['movpercvai'] == '0') {
               $txt .= '<td>' . '' . '</td>';
          } else {
               $txt .= '<td class="text-center">' . number_format($reg['movpercvai'], 0, ",", ".") . '%' . '</td>';
          }
          if ($reg['movpercvolta'] == '0') {
               $txt .= '<td>' . '' . '</td>';
          } else {
               $txt .= '<td class="text-center">' . number_format($reg['movpercvolta'], 0, ",", ".") . '%' . '</td>';
          }
          $txt .= '<td>' . $reg['movobservacao'] . '</td>';
          $txt .= '</tr>';
          echo $txt;
     }
     return $nro;
}

?>

</html>