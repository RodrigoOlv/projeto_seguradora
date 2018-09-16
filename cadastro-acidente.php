<?php
// Para usar a FK
  require_once 'modelo/veiculo.class.php';
  require_once 'dao/veiculodao.class.php';
  $veiDAO = new VeiculoDAO();
  $veiculos = $veiDAO->buscarVeiculo();
 ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Cadastro de Acidente</title>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
  <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="vendor/components/jquery/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.3/js/tether.min.js"></script>
  <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
  <body class="bg-dark">
      <div class="container-fluid">
        <h1 class="jumbotron bg-warning">Cadastro de Acidente</h1>

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
                <li class="nav-item">
                  <a class="nav-link" href="cadastro-veiculo.php">Veículo</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="cadastro-apolice.php">Apólice</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active" href="cadastro-acidente.php">Acidente</a>
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
          <h2 class="text-light mt-5 mb-5">Cadastro e Controle de Apólices de Seguros Veiculares</h2>

          <form name="cadacidente" method="post" action="">
            <div class="form-group">
              <input type="text" name="txtlocal" placeholder="Local do Sinistro" class="form-control">
            </div>

            <div class="row">
              <div class="form-group col-md-6">
                <input type="date" name="dtdata" placeholder="Data do Sinistro" class="form-control">
              </div>
              <div class="form-group col-md-6">
                <input type="time" name="tmhorario" placeholder="Horário do Sinistro" class="form-control">
                </select>
              </div>
            </div>

            <div class="form-group">
              <select class="form-control" name="selregistroveiculo">
                <option value="registroveiculo">Registro do Veículo</option>
                <?php
                foreach ($veiculos as $v) {
                  echo "<option value='$v->registro'>$v->registro</option>";
                }
                ?>
              </select>
            </div>

            <div>
              <input type="submit" name="cadastrar" value="Cadastrar" class="btn btn-warning">
              <input type="reset" name="Limpar" value="Limpar" class="btn btn-light">
            </div>
          </form>

        </div>
        <div class="container-fluid">
          <?php
            if(isset($_POST['cadastrar'])){

              include_once 'modelo/acidente.class.php';
              include_once 'dao/acidentedao.class.php';
              include_once 'util/padronizacao.class.php';
              include_once 'util/helper.class.php';
              include_once 'util/validacao.class.php';

              $qtdErros = 0;

              // var_dump($_POST['dtdata']);

              if(!Validacao::antiXSS($_POST['txtlocal'])){
                $qtdErros++;
                Helper::alert("Local inválido!");
              }else if(!Validacao::validarData($_POST['dtdata'])){
                $qtdErros++;
                Helper::alert("Data inválida!");
              }else if(!Validacao::validarHorario($_POST['tmhorario'])){
                $qtdErros++;
                Helper::alert("Horário Inválido!");
              }else if(!Validacao::validarFK($_POST['selregistroveiculo'])){
                $qtdErros++;
                Helper::alert("Registro inválido!");
              }

              if($qtdErros == 0){

                $aci = new Acidente();

                $aci->localSinistro = Padronizacao::padronizarMaiMin($_POST['txtlocal']);
                $aci->dataSinistro = Padronizacao::padronizarData($_POST['dtdata']);
                $aci->horario = Padronizacao::padronizarHorario($_POST['tmhorario']);
                $aci->registroVeiculo = $_POST['selregistroveiculo'];

                // echo $aci;

                $aciDAO = new AcidenteDAO();

                $aciDAO->cadastrarAcidente($aci);

                Helper::alert("Acidente cadastrado com sucesso!");
              }//if 0 erros
            }
          ?>
        </div>

      </div>
  </body>
</html>
