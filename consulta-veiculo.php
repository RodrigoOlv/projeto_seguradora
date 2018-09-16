<?php
session_start();
ob_start();

require_once 'dao/veiculodao.class.php';
require_once 'modelo/veiculo.class.php';
require_once 'util/helper.class.php';

$veiDAO = new VeiculoDAO();

$veiculos = $veiDAO->buscarVeiculo();
// var_dump($veiculos);
 ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Consulta de Veículos</title>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
  <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css"> -->
  <script src="vendor/components/jquery/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.3/js/tether.min.js"></script>
  <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
  <body class="bg-dark">
      <div class="container-fluid">
        <h1 class="jumbotron bg-warning">Consulta de Veículos</h1>

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
          <h2 class="text-light mt-5 mb-5">Veículos</h2>

          <form name="filtroclientes" method="post" action="">
            <div class="row">
              <div class="form-group col-md-6">
                <input type="text" name="txtfiltro" placeholder="Digite o que deseja filtrar" class="form-control animated">
              </div>
              <div class="form-group col-md-6">
                <select class="form-control" name="selfiltro">
                  <option value="selecione">Selecione</option>
                  <option value="codigo">Código</option>
                  <option value="marca">Marca</option>
                  <option value="modelo">Modelo</option>
                  <option value="placa">placa</option>
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
                $clientes = $cliDAO->buscarVeiculo();
                $qtdErros++;
              }

              if($qtdErros == 0){

                $query = "";

                if($filtro == 'codigo') $query = "where registro = ".$pesquisa;
                elseif($filtro == 'marca') $query = "where marca = '".$pesquisa."'";
                elseif($filtro == 'modelo') $query = "where modelo '".$pesquisa."'";
                elseif($filtro == 'placa') $query = "where placa = '".$pesquisa."'";

                // var_dump($query);
                $veiculos = $veiDAO->filtrarVeiculo($query);
              }//if qtderros é 0
            }//if isset session msg

            // var_dump($clientes);
            if(count($veiculos) == 0){
              Helper::alert("Não há dados no banco!");
              echo "<h2 class='text-light mt-5'>Nenhum veículo cadastrado</h2>";
              die();
            }
           ?>

           <div class="table-resposive">
             <table class="table table-striped table-bordered table-hover bg-light">
               <thead>
                 <tr>
                   <th>Código</th>
                   <th>Marca</th>
                   <th>Modelo</th>
                   <th>Placa</th>
                   <th>Alterar</th>
                   <th>Excluir</th>
                 </tr>
               </thead>
               <tfoot>
                 <tr>
                   <th>Código</th>
                   <th>Marca</th>
                   <th>Modelo</th>
                   <th>Placa</th>
                   <th>Alterar</th>
                   <th>Excluir</th>
                 </tr>
               </tfoot>
               <tbody>
                 <?php
                 foreach ($veiculos as $v) {
                   echo "<tr>";
                    echo "<td>$v->registro</td>";
                    echo "<td>$v->marca</td>";
                    echo "<td>$v->modelo</td>";
                    echo "<td>$v->placa</td>";
                    echo "<td><a href='alterar-veiculo.php?registro=$v->registro'><button type='button' class='btn btn-info'><span class='glyphicon glyphicon-edit'></span> Alterar</button></a></td>";
                    echo "<td><a href='consulta-veiculo.php?registro=$v->registro'><button type='button' class='btn btn-danger'><span class='glyphicon glyphicon-remove'></span>Excluir</button></a></td>";
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
          if(isset($_GET['registro'])){
            // var_dump($_GET['id']);
            $veiDAO->deletarVeiculo($_GET['registro']);
            //
            $_SESSION['msg']="Veiculo excluido com sucesso!";
            // Helper::alert($_SESSION['msg']);
            header("location:consulta-veiculo.php");
            //
            unset($_GET['registro']);
          }
         ?>

        </div>
      </div>
  </body>
</html>
