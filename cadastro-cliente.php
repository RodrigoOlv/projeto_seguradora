<?php
  session_start();
  ob_start();

  if(!isset($_SESSION['login'])) header("location:login.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Cadastro de Cliente</title>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
  <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="vendor/components/jquery/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.3/js/tether.min.js"></script>
  <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
  <body class="bg-dark">
      <div class="container-fluid">
        <h1 class="jumbotron bg-warning">Cadastro de Clientes</h1>

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
                <li class="nav-item active">
                  <a class="nav-link" href="cadastro-cliente.php">Cliente <span class="sr-only">(current)</span></a>
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

          <form name="cadcliente" method="post" action="">

            <div class="row">

              <div class="form-group col-md-6">
                <input type="text" name="txtnome" placeholder="Nome" class="form-control">
              </div>
              <div class="form-group col-md-6">
                <input type="text" name="txtsobrenome" placeholder="Sobrenome" class="form-control">
              </div>

            </div>
            <div>
              <div class="row">
                <div class="form-group col-md-6">
                  <input type="num" name="numcpf" placeholder="CPF" class="form-control">
                </div>
                <div class="form-group col-md-6">
                  <input type="text" name="txttelefone" placeholder="Telefone (XX) XXXX-XXXX" class="form-control">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-md-6">
                <input type="text" name="txtlogradouro" placeholder="Logradouro" class="form-control">
              </div>
              <div class="form-group col-md-2">
                <input type="number" name="numnumero" placeholder="Numero" class="form-control">
              </div>
              <div class="form-group col-md-4">
                <input type="text" name="txtbairro" placeholder="Bairro" class="form-control">
              </div>
            </div>

            <div class="row">
              <div class="form-group col-md-6">
                <input type="text" name="txtcidade" placeholder="Cidade" class="form-control">
              </div>
              <div class="form-group col-md-3">
                <select name="seluf" class="form-control">
                  <option value="">UF</option>
                  <option value="PR">PR</option>
                  <option value="RS">RS</option>
                  <option value="SC">SC</option>
                </select>
              </div>
              <div class="form-group col-md-3">
                <input type="text" name="txtcep" placeholder="CEP" class="form-control">
              </div>
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

            include_once 'modelo/cliente.class.php';
            include_once 'dao/clientedao.class.php';
            include_once 'util/padronizacao.class.php';
            include_once 'util/helper.class.php';
            include_once 'util/validacao.class.php';

            $qtdErros = 0;

            if(!Validacao::validarNome($_POST['txtnome'])){
              $qtdErros++;
              Helper::alert("Nome inválido!");
            }else if(!Validacao::validarSobrenome($_POST['txtsobrenome'])){
              $qtdErros++;
              Helper::alert("Sobrenome inválido!");
            }else if(!Validacao::validarCPF($_POST['numcpf'])){
              $qtdErros++;
              Helper::alert("CPF Inválido!");
            }else if(!Validacao::validarTelefone($_POST['txttelefone'])){
                $qtdErros++;
                Helper::alert("Telefone inválido");
            }else if(!Validacao::validarLogradouro($_POST['txtlogradouro'])){
                $qtdErros++;
                Helper::alert("Logradouro inválido");
            }else if(!Validacao::validarNumero($_POST['numnumero'])){
                $qtdErros++;
                Helper::alert("Número inválido");
            }else if(!Validacao::validarCEP($_POST['txtcep'])){
                $qtdErros++;
                Helper::alert("CEP inválido");
            }else if(!Validacao::validarBairro($_POST['txtbairro'])){
                $qtdErros++;
                Helper::alert("Bairro inválido");
            }else if(!Validacao::validarCidade($_POST['txtcidade'])){
                $qtdErros++;
                Helper::alert("Cidade inválida");
            }else if(!Validacao::validarUF($_POST['seluf'])){
                $qtdErros++;
                Helper::alert("UF inválida");
            }

            if($qtdErros == 0){

              $cli = new Cliente();

              $cli->nome = Padronizacao::padronizarMaiMin($_POST['txtnome']);
              $cli->sobrenome = Padronizacao::padronizarMaiMin($_POST['txtsobrenome']);
              $cli->cpf = $_POST['numcpf'];
              $cli->telefone = $_POST['txttelefone'];
              $cli->logradouro = Padronizacao::padronizarMaiMin($_POST['txtlogradouro']);
              $cli->numero = $_POST['numnumero'];
              $cli->cep = $_POST['txtcep'];
              $cli->bairro = Padronizacao::padronizarMaiMin($_POST['txtbairro']);
              $cli->cidade = Padronizacao::padronizarMaiMin($_POST['txtcidade']);
              $cli->uf = Padronizacao::padronizarUF($_POST['seluf']);

              $cliDAO = new ClienteDAO();

              $cliDAO->cadastrarCliente($cli);

              Helper::alert("Cliente cadastrado com sucesso!");
            }//if 0 erros
          }//if post cadastrar
          ?>
        </div>

      </div>
  </body>
</html>
