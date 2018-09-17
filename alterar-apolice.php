<?php
  session_start();
  ob_start();

  if(!isset($_SESSION['login'])) header("location:login.php");

  include_once 'util/padronizacao.class.php';

  if(isset($_GET['numero'])){

    include_once 'modelo/apolice.class.php';
    include_once 'dao/apolicedao.class.php';

    $apoDAO = new ApoliceDAO();

    $query = "where numero = ".$_GET['numero'];

    $apolices = $apoDAO->filtrarApolice($query);
    $apolice = $apolices[0];

    $listaApolices = $apoDAO->buscarApolice();
  }
 ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Alterar Apólice</title>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
  <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="vendor/components/jquery/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.3/js/tether.min.js"></script>
  <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
  <body class="bg-dark">
      <div class="container-fluid">
        <h1 class="jumbotron bg-warning">Alterar Apólice</h1>

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
                  <a class="nav-link" href="cadastro-cliente.php">Cliente</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="cadastro-veiculo.php">Veículo <span class="sr-only">(current)</span></a>
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

          <form name="altapolice" method="post" action="">

            <div class="form-group">
              <input type="text" name="txtvalor" placeholder="Valor (apenas números)" class="form-control" value="<?php echo Padronizacao::padronizarValorAlterar($apolice->valor) ?>">
            </div>

            <div class="row">
              <div class="form-group col-md-6">
                <select class="form-control" name="selregistroveiculo">
                  <option value="registroveiculo">Registro do Veículo</option>
                  <?php
                  foreach ($listaApolices as $ap) {
                    echo "<option value='$ap->registro_veiculo'";
                    echo "if($apolice->registro_veiculo == $ap->registro_veiculo) echo ";
                    echo "selected = 'selected'";
                    echo ">$ap->registro_veiculo</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="form-group col-md-6">
                <select class="form-control" name="selidcliente">
                  <option value="codigocliente">Código do Cliente</option>
                  <?php
                  foreach ($listaApolices as $ap) {
                    echo "<option value='$ap->id_cliente'";
                    echo "if($apolice->id_cliente == $ap->id_cliente) echo ";
                    echo "selected = 'selected'";
                    echo ">$ap->id_cliente</option>";
                  }
                  ?>
                </select>
              </div>
            </div>

            <div>
              <input type="submit" name="alterar" value="Alterar" class="btn btn-warning">
              <input type="reset" name="Limpar" value="Limpar" class="btn btn-light">
            </div>


          </form>
        </div>
        <div class="container-fluid">
          <?php
          if(isset($_POST['alterar'])){

            include_once 'modelo/apolice.class.php';
            include_once 'dao/apolicedao.class.php';
            include_once 'util/padronizacao.class.php';
            include_once 'util/helper.class.php';
            include_once 'util/validacao.class.php';

            $qtdErros = 0;

            if(!Validacao::validarValorAlterar($_POST['txtvalor'])){
              $qtdErros++;
              Helper::alert("Valor inválido!");
            }else if(!Validacao::validarFK($_POST['selregistroveiculo'])){
              $qtdErros++;
              Helper::alert("Registro inválido!");
            }else if(!Validacao::validarFK($_POST['selidcliente'])){
              $qtdErros++;
              Helper::alert("ID Inválido!");
            }

            if($qtdErros == 0){

              $apo = new Apolice();

              $apo->numero = $apolice->numero;
              $apo->valor = $_POST['txtvalor'];
              $apo->registroVeiculo = $_POST['selregistroveiculo'];
              $apo->idCliente = $_POST['selidcliente'];

              var_dump($apo);

              $apoDAO = new apoliceDAO();

              $apoDAO->alterarApolice($apo);

              $_SESSION['msg'] = "Apólice alterada com sucesso!";
              header("location:consulta-apolice.php");
              unset($_POST);
            }//if 0 erros
          }//if post
          ?>
        </div>

      </div>
  </body>
</html>
