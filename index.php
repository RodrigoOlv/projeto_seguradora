<?php
  session_start();
  ob_start();

  if(!isset($_SESSION['login'])) header("location:login.php");

  // unset($_SESSION['login']);
 ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Página Inicial</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="vendor/components/jquery/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.3/js/tether.min.js"></script>
  <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
<body class="bg-dark">
  <div class="container-fluid">
    <h1 class="jumbotron bg-warning">Seja bem vindo!</h1>


    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Menu</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="cadastro-cliente.php">Cliente</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="cadastro-veiculo.php">Veículo</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="cadastro-cliente.php">Apólice</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="cadastro-cliente.php">Acidente</a>
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
      <h2 class="text-light mt-5">Cadastro e Controle de Apólices de Seguros Veiculares</h2>
    </div>
  </div>
</body>
</html>
