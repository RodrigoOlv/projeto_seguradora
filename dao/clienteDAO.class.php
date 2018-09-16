<?php
require_once "conexaobanco.class.php";

class ClienteDAO {

	private $conexao = null;

	public function __construct(){
		$this->conexao = ConexaoBanco::getInstance();
	}

	public function __destruct(){}

	public function cadastrarCliente($cli){
		try{
			$stat = $this->conexao->prepare("insert into cliente(id, nome, sobrenome, cpf, telefone, logradouro, numero, bairro, cidade, uf, cep) VALUES(null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stat->bindValue(1, $cli->nome);
			$stat->bindValue(2, $cli->sobrenome);
			$stat->bindValue(3, $cli->cpf);
			$stat->bindValue(4, $cli->telefone);
			$stat->bindValue(5, $cli->logradouro);
			$stat->bindValue(6, $cli->numero);
			$stat->bindValue(7, $cli->bairro);
			$stat->bindValue(8, $cli->cidade);
			$stat->bindValue(9, $cli->uf);
			$stat->bindValue(10, $cli->cep);
			$stat->execute();
		}catch(PDOException $e){
			echo "Erro ao cadastrar cliente!" . $e;
		}//catch
	}//cadastrarCliente

	public function buscarCliente(){
    try{
      $stat = $this->conexao->query("select * from cliente");
      $array = $stat->fetchAll(PDO::FETCH_CLASS,'Cliente');
      return $array;
    }catch(PDOException $e){
      echo "Erro ao buscar clientes! ".$e;
    }//catch
  }//buscarCliente

	public function deletarCliente($id){
    try{
      $stat = $this->conexao->prepare("delete from cliente where id = ?");
      $stat->bindValue(1,$id);
      $stat->execute();
    }catch(PDOException $e){
      echo "Erro ao excluir cliente! ".$e;
    }//catch
  }//deletar cliente

	public function filtrarCliente($query){
		try {
			$stat = $this->conexao->query("select * from cliente ".$query);
			$array = $stat->fetchAll(PDO::FETCH_CLASS, 'Cliente');
			return $array;
		} catch (PDOException $e) {
			echo "Erro ao filtrar cliente!".$e;
		}//catch
	}//filtrar cliente

	public function alterarCliente($cli){
		try{
			$stat = $this->conexao->prepare("update cliente set nome = ?, sobrenome = ?, cpf = ?, telefone = ?, logradouro = ?, numero = ?, bairro = ?, cidade = ?, uf = ?, cep = ? where id = ?");
			$stat->bindValue(1, $cli->nome);
			$stat->bindValue(2, $cli->sobrenome);
			$stat->bindValue(3, $cli->cpf);
			$stat->bindValue(4, $cli->telefone);
			$stat->bindValue(5, $cli->logradouro);
			$stat->bindValue(6, $cli->numero);
			$stat->bindValue(7, $cli->bairro);
			$stat->bindValue(8, $cli->cidade);
			$stat->bindValue(9, $cli->uf);
			$stat->bindValue(10, $cli->cep);
			$stat->bindValue(11, $cli->id);
			$stat->execute();
		}catch(PDOException $e){
			echo "Erro ao alterar livro!" . $e;
		}//catch
	}//alterarCliente
}//fecha classe
