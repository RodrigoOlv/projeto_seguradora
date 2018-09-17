<?php
  session_start();
  ob_start();

  if(!isset($_SESSION['login'])) header("location:login.php");

  require_once 'dao/apolicedao.class.php';
  require_once 'modelo/apolice.class.php';
  require_once 'util/helper.class.php';

  $apoDAO = new ApoliceDAO();

  $apolices = $apoDAO->buscarApolice();
 ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Consulta de Apólices</title>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
  <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="vendor/components/jquery/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.3/js/tether.min.js"></script>
  <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
  <body class="bg-dark">
      <div class="container-fluid">
        <h1 class="jumbotron bg-warning">Consulta de Apólices</h1>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">
            <a class="navbar-brand" href="#">Menu</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="cadastro-cliente.php">Cliente</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="cadastro-veiculo.php">Veículo</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="cadastro-apolice.php">Apólice</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="cadastro-acidente.php">Acidente</a>
                </li>
                <li class="dropdown">
                  <button class="btn btn-light dropdown-toggle nav-item" type="button" id="droptdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Consulta
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item nav-link" href="consulta-cliente.php">Clientes</a>
                    <a class="dropdown-item nav-link" href="consulta-veiculo.php">Veiculos</a>
                    <a class="dropdown-item nav-link" href="consulta-apolice.php">Apólices</a>
                    <a class="dropdown-item nav-link" href="consulta-acidente.php">Acidentes</a>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </nav>

        <div class="container-fluid">
          <h2 class="text-light mt-5 mb-5">Apólices</h2>

          <form name="filtroclientes" method="post" action="">
            <div class="row">
              <div class="form-group col-md-6">
                <input type="text" name="txtfiltro" placeholder="Digite o que deseja filtrar" class="form-control animated">
              </div>
              <div class="form-group col-md-6">
                <select class="form-control" name="selfiltro">
                  <option value="selecione">Selecione</option>
                  <option value="codigo">Código</option>
                  <option value="valor">Valor</option>
                  <option value="registroveiculo">Registro do Veículo</option>
                  <option value="codigocliente">Código do Cliente</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <input type="submit" name="pesquisar" value="Pesquisar" class="form-control animated btn-warning">
            </div>
          </form>

          <?php
            if(isset($_SESSION['msg'])){
              Helper::alert($_SESSION['msg']);
              Helper::h2($_SESSION['msg']);
              unset($_SESSION['msg']);
            }

            // Filtro
            if(isset($_POST['pesquisar'])){

              $filtro = $_POST['selfiltro'];
              $pesquisa = $_POST['txtfiltro'];
              $qtdErros = 0;

              if($filtro == "selecione" || $pesquisa == ""){
                $apolices = $apoDAO->buscarApolice();
                $qtdErros++;
              }

              if($qtdErros == 0){

                $query = "";

                if($filtro == 'codigo') $query = "where numero = ".$pesquisa;
                elseif($filtro == 'valor') $query = "where valor = '".$pesquisa."'";
                elseif($filtro == 'registroveiculo') $query = "where registro_veiculo ".$pesquisa;
                elseif($filtro == 'codigocliente') $query = "where id_cliente = ".$pesquisa;

                // var_dump($query);
                $apolices = $apoDAO->filtrarApolice($query);
              }//if qtderros é 0
            }//if isset session msg

            // var_dump($clientes);
            if(count($apolices) == 0){
              Helper::alert("Não há dados no banco!");
              echo "<h2 class='text-light mt-5'>Nenhuma apólice cadastrada</h2>";
              die();
            }
           ?>

           <div class="table-resposive">
             <table class="table table-striped table-bordered table-hover bg-light">
               <thead>
                 <tr>
                   <th>Código</th>
                   <th>Valor</th>
                   <th>Registro do Veículo</th>
                   <th>Código do Cliente</th>
                   <th>Alterar</th>
                   <th>Excluir</th>
                 </tr>
               </thead>
               <tfoot>
                 <tr>
                   <th>Código</th>
                   <th>Valor</th>
                   <th>Registro do Veículo</th>
                   <th>Código do Cliente</th>
                   <th>Alterar</th>
                   <th>Excluir</th>
                 </tr>
               </tfoot>
               <tbody>
                 <?php
                   foreach ($apolices as $ap) {
                     echo "<tr>";
                      echo "<td>$ap->numero</td>";
                      echo "<td>$ap->valor</td>";
                      echo "<td>$ap->registro_veiculo</td>";
                      echo "<td>$ap->id_cliente</td>";
                      echo "<td><a href='alterar-apolice.php?numero=$ap->numero'><button type='button' class='btn btn-info'><span class='glyphicon glyphicon-edit'></span> Alterar</button></a></td>";
                      echo "<td><a href='consulta-apolice.php?numero=$ap->numero'><button type='button' class='btn btn-danger'><span class='glyphicon glyphicon-remove'></span>Excluir</button></a></td>";
                     echo "</tr>";
                   }
                  ?>
               </tbody>
             </table>
           </div><!-- table resposive -->
        </div>

        <div class="container-fluid">

        <!-- PHP -->
        <?php
          if(isset($_GET['numero'])){
            // var_dump($_GET['id']);
            $apoDAO->deletarApolice($_GET['numero']);
            //
            $_SESSION['msg']="Apólice excluída com sucesso!";
            // Helper::alert($_SESSION['msg']);
            header("location:consulta-apolice.php");
            //
            unset($_GET['numero']);
          }
         ?>

        </div>
      </div>
  </body>
</html>
