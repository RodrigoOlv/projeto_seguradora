<?php
  session_start();
  ob_start();

  if(!isset($_SESSION['login'])) header("location:login.php");
 ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Cadastro de Veiculo</title>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
  <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="vendor/components/jquery/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.3/js/tether.min.js"></script>
  <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
  <body class="bg-dark">
      <div class="container-fluid">
        <h1 class="jumbotron bg-warning">Cadastro de Veículo</h1>

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
                <li class="nav-item">
                  <a class="nav-link" href="cadastro-cliente.php">Cliente <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
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
                <li>
                  <div class="d-flex flex-row">
                    <form name="sair" method="post" action="">
                      <button class="btn btn-light nav-item p-2" type="submit" name="sair">
                        Sair
                      </button>
                    </form>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </nav>

        <?php
          if(isset($_POST['sair'])){
            unset($_SESSION['login']);
            header("location:login.php");
          }
         ?>

        <div class="container-fluid">
          <h2 class="text-light mt-5 mb-5">Cadastro e Controle de Apólices de Seguros Veiculares</h2>

          <form name="cadveiculo" method="post" action="">

            <div class="row">
              <div class="form-group col-md-6">
                <input type="text" name="txtmarca" placeholder="Marca" class="form-control">
              </div>
              <div class="form-group col-md-6">
                <input type="text" name="txtmodelo" placeholder="Modelo" class="form-control">
              </div>
            </div>

            <div class="form-group">
              <input type="text" name="txtplaca" placeholder="Placa" class="form-control">
            </div>
            <div class="form-group">
              <input type="submit" name="cadastrar" value="Cadastrar" class="btn btn-warning">
              <input type="reset" name="Limpar" value="Limpar" class="btn btn-light">
            </div>


          </form>
        </div>
        <div class="container-fluid">
          <?php
          if(isset($_POST['cadastrar'])){

            include_once 'modelo/veiculo.class.php';
            include_once 'dao/veiculodao.class.php';
            include_once 'util/padronizacao.class.php';
            include_once 'util/helper.class.php';
            include_once 'util/validacao.class.php';

            $qtdErros = 0;

            if(!Validacao::validarMarca($_POST['txtmarca'])){
              $qtdErros++;
              Helper::alert("Marca inválida!");
            }else if(!Validacao::validarModelo($_POST['txtmodelo'])){
              $qtdErros++;
              Helper::alert("Modelo inválido!");
            }else if(!Validacao::validarPlaca($_POST['txtplaca'])){
              $qtdErros++;
              Helper::alert("Placa Inválida!");
            }

            if($qtdErros == 0){

              $vei = new Veiculo();

              $vei->marca = Padronizacao::padronizarMaiMin($_POST['txtmarca']);
              $vei->modelo = Padronizacao::padronizarMaiMin($_POST['txtmodelo']);
              $vei->placa = $_POST['txtplaca'];

              $veiDAO = new VeiculoDAO();

              $veiDAO->cadastrarVeiculo($vei);

              Helper::alert("Veículo cadastrado com sucesso!");
            }//if 0 erros
          }//if post cadastrar
          ?>
        </div>

      </div>
  </body>
</html>
