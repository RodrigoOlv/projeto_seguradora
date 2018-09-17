<?php
session_start();
ob_start();

if(!isset($_SESSION['login'])) header("location:login.php");

require_once 'dao/clientedao.class.php';
require_once 'modelo/cliente.class.php';
require_once 'util/helper.class.php';

$cliDAO = new ClienteDAO();

$clientes = $cliDAO->buscarCliente();
 ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Consulta de Cliente</title>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
  <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="vendor/components/jquery/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.3/js/tether.min.js"></script>
  <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
  <body class="bg-dark">
      <div class="container-fluid">
        <h1 class="jumbotron bg-warning">Consulta de Clientes</h1>

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
          <h2 class="text-light mt-5 mb-5">Clientes</h2>

          <form name="filtroclientes" method="post" action="">
            <div class="row">
              <div class="form-group col-md-6">
                <input type="text" name="txtfiltro" placeholder="Digite o que deseja filtrar" class="form-control animated">
              </div>
              <div class="form-group col-md-6">
                <select class="form-control" name="selfiltro">
                  <option value="selecione">Selecione</option>
                  <option value="codigo">Código</option>
                  <option value="nome">Nome</option>
                  <option value="sobrenome">Sobrenome</option>
                  <option value="cpf">CPF</option>
                  <option value="telefone">Telefone</option>
                  <option value="logradouro">Logradouro</option>
                  <option value="numero">Número</option>
                  <option value="cep">CEP</option>
                  <option value="bairro">Bairro</option>
                  <option value="cidade">Cidade</option>
                  <option value="uf">UF</option>
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
                $clientes = $cliDAO->buscarCliente();
                $qtdErros++;
              }

              if($qtdErros == 0){

                $query = "";

                if($filtro == 'codigo') $query = "where id = ".$pesquisa;
                elseif($filtro == 'nome') $query = "where nome = '".$pesquisa."'";
                elseif($filtro == 'sobrenome') $query = "where sobrenome '".$pesquisa."'";
                elseif($filtro == 'cpf') $query = "where cpf = ".$pesquisa;
                elseif($filtro == 'telefone') $query = "where telefone = '".$pesquisa."'";
                elseif($filtro == 'logradouro') $query = "where logradouro = '".$pesquisa."'";
                elseif($filtro == 'numero') $query = "where numero = '".$pesquisa."'";
                elseif($filtro == 'cep') $query = "where cep = '".$pesquisa."''";
                elseif($filtro == 'bairro') $query = "where bairro = '".$pesquisa."'";
                elseif($filtro == 'cidade') $query = "where cidade = '".$pesquisa."'";
                elseif($filtro == 'uf') $query = "where uf = '".$pesquisa."'";

                // var_dump($query);
                $clientes = $cliDAO->filtrarCliente($query);
              }//if qtderros é 0
            }//if isset session msg

            // var_dump($clientes);
            if(count($clientes) == 0){
              Helper::alert("Não há dados no banco!");
              echo "<h2 class='text-light mt-5'>Nenhum cliente cadastrado</h2>";
              die();
            }
           ?>

           <div class="table-resposive">
             <table class="table table-striped table-bordered table-hover bg-light">
               <thead>
                 <tr>
                   <th>Código</th>
                   <th>Nome</th>
                   <!-- <th>Sobrenome</th> -->
                   <th>CPF</th>
                   <th>Telefone</th>
                   <th>Endereço</th>
                   <!-- <th>Número</th> -->
                   <th>Bairro</th>
                   <th>Cidade</th>
                   <th>UF</th>
                   <th>CEP</th>
                   <th>Alterar</th>
                   <th>Excluir</th>
                 </tr>
               </thead>
               <tfoot>
                 <tr>
                   <th>Código</th>
                   <th>Nome</th>
                   <!-- <th>Sobrenome</th> -->
                   <th>CPF</th>
                   <th>Telefone</th>
                   <th>Endereço</th>
                   <!-- <th>Número</th> -->
                   <th>Bairro</th>
                   <th>Cidade</th>
                   <th>UF</th>
                   <th>CEP</th>
                   <th>Alterar</th>
                   <th>Excluir</th>
                 </tr>
               </tfoot>
               <tbody>
                 <?php
                 foreach ($clientes as $c) {
                   echo "<tr>";
                    echo "<td>$c->id</td>";
                    echo "<td>$c->nome $c->sobrenome</td>";
                    // echo "<td>$c->sobrenome</td>";
                    echo "<td>$c->cpf</td>";
                    echo "<td>$c->telefone</td>";
                    echo "<td>$c->logradouro, $c->numero</td>";
                    // echo "<td>$c->numero</td>";
                    echo "<td>$c->bairro</td>";
                    echo "<td>$c->cidade</td>";
                    echo "<td>$c->uf</td>";
                    echo "<td>$c->cep</td>";
                    echo "<td><a href='alterar-cliente.php?id=$c->id'><button type='button' class='btn btn-info'><span class='glyphicon glyphicon-edit'></span> Alterar</button></a></td>";
                    echo "<td><a href='consulta-cliente.php?id=$c->id'><button type='button' class='btn btn-danger'><span class='glyphicon glyphicon-remove'></span>Excluir</button></a></td>";
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
          if(isset($_GET['id'])){
            // var_dump($_GET['id']);
            $cliDAO->deletarCliente($_GET['id']);
            //
            $_SESSION['msg']="Cliente excluido com sucesso!";
            // Helper::alert($_SESSION['msg']);
            header("location:consulta-cliente.php");
            //
            unset($_GET['id']);
          }
         ?>

        </div>
      </div>
  </body>
</html>
