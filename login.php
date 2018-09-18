<?php
session_start();
ob_start();

include_once 'modelo/usuario.class.php';
include_once 'dao/usuariodao.class.php';
require_once 'util/helper.class.php';
require_once 'util/validacao.class.php';

$user = new Usuario();
$userDAO = new UsuarioDAO();
 ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="vendor/components/jquery/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.3/js/tether.min.js"></script>
  <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
<body class="bg-dark">
  <div class="container-fluid">
    <h1 class="jumbotron bg-warning">Login</h1>
    <div class="container-fluid">
      <h2 class="text-light mt-5">Cadastro e Controle de Apólices de Seguros Veiculares</h2>
    </div>
  </div>
  <div class="container-fluid nav-bar">
    <div class="mt-5">
      <p class="h4 bg-light container-fluid p-3">Faça o login para continuar</p>
    </div>

    <div class="mt-5">
      <form name="login" method="post" action="">
        <div class="row">
          <div class="form-group col-md-6">
            <input type="text" name="txtlogin" placeholder="Login" class="form-control">
          </div>
          <div class="form-group col-md-6">
            <input type="password" name="passenha" placeholder="Senha" class="form-control">
          </div>
        </div>
        <div class="form-group">
          <input type="submit" name="entrar" value="Entrar" class="form-control btn-warning">
        </div>
      </form>
    </div>

    <?php
      if(isset($_POST['entrar'])){

        $user->login = Validacao::antiXSS($_POST['txtlogin']);
        $user->senha = Validacao::antiXSS($_POST['passenha']);

        $qtdErros = 0;

        if($user->login == ''|| $user->senha == ''){
            $qtdErros++;
            Helper::alert("Login ou senha inválidos!");
        }

        if($qtdErros == 0){
          $query = "where login_usuario = '".$user->login."'";

          $usuarios = $userDAO->filtrarUsuario($query);

          if($user->senha == $usuarios[0]->senha_usuario){
            // var_dump($user);
            $_SESSION['login'] = serialize($user);
            header("location:index.php");
          }
          else{
            Helper::alert("Login ou senha inválidos!");
            header("location:login.php");
          }//se o login do form não é igual ao do array
        }//se zero erros
      }//se existe post de entrar
     ?>

  </div>
</body>
</html>
