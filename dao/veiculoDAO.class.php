<?php
require_once "conexaobanco.class.php";

class VeiculoDAO {

	private $conexao = null;

	public function __construct(){
		$this->conexao = ConexaoBanco::getInstance();
	}

	public function __destruct(){}

	public function cadastrarVeiculo($vei){
		try{
			$stat = $this->conexao->prepare("insert into veiculo(registro, marca, modelo, placa) VALUES(null, ?, ?, ?)");
			$stat->bindValue(1, $vei->marca);
			$stat->bindValue(2, $vei->modelo);
			$stat->bindValue(3, $vei->placa);
			$stat->execute();
		}catch(PDOException $e){
			echo "Erro ao cadastrar veiculo!" . $e;
		}//catch
	}//cadastrar veiculo

	public function buscarVeiculo(){
    try{
      $stat = $this->conexao->query("select * from veiculo");
      $array = $stat->fetchAll(PDO::FETCH_CLASS,'Veiculo');
      return $array;
    }catch(PDOException $e){
      echo "Erro ao buscar veículos! ".$e;
    }//catch
  }//buscarCliente

	public function deletarVeiculo($registro){
    try{
      $stat = $this->conexao->prepare("delete from veiculo where registro = ?");
      $stat->bindValue(1, $registro);
      $stat->execute();
    }catch(PDOException $e){
      echo "Erro ao excluir veículo! ".$e;
    }//catch
  }//deletar cliente

	public function filtrarVeiculo($query){
		try {
			$stat = $this->conexao->query("select * from veiculo ".$query);
			$array = $stat->fetchAll(PDO::FETCH_CLASS, 'Veiculo');
			return $array;
		} catch (PDOException $e) {
			echo "Erro ao filtrar veículo!".$e;
		}//catch
	}//filtrar cliente

	public function alterarVeiculo($vei){
		try{
			$stat = $this->conexao->prepare("update veiculo set marca = ?, modelo = ?, placa = ? where registro = ?");
			$stat->bindValue(1, $vei->marca);
			$stat->bindValue(2, $vei->modelo);
			$stat->bindValue(3, $vei->placa);
			$stat->bindValue(4, $vei->registro);
			$stat->execute();
		}catch(PDOException $e){
			echo "Erro ao alterar veiculo!" . $e;
		}//catch
	}//alterarCliente
}//fecha classe
