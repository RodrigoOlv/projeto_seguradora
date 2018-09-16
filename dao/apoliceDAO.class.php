<?php
require_once "conexaobanco.class.php";

class ApoliceDAO {

	private $conexao = null;

	public function __construct(){
		$this->conexao = ConexaoBanco::getInstance();
	}

	public function __destruct(){}

	public function cadastrarApolice($apo){
		try{
			$stat = $this->conexao->prepare("insert into apolice(numero, valor, registro_veiculo, id_cliente) VALUES(null, ?, ?, ?)");
			$stat->bindValue(1, $apo->valor);
			$stat->bindValue(2, $apo->registroVeiculo);
			$stat->bindValue(3, $apo->idCliente);
			$stat->execute();
		}catch(PDOException $e){
			echo "Erro ao cadastrar apólice!" . $e;
		}//catch
	}//cadastrar veiculo

	public function buscarApolice(){
    try{
      $stat = $this->conexao->query("select * from apolice");
      $array = $stat->fetchAll(PDO::FETCH_CLASS,'Apolice');
      return $array;
    }catch(PDOException $e){
      echo "Erro ao buscar apólices! ".$e;
    }//catch
  }//buscarCliente

	public function deletarApolice($numero){
    try{
      $stat = $this->conexao->prepare("delete from apolice where numero = ?");
      $stat->bindValue(1, $numero);
      $stat->execute();
    }catch(PDOException $e){
      echo "Erro ao excluir apólice! ".$e;
    }//catch
  }//deletar cliente

	public function filtrarApolice($query){
		try {
			$stat = $this->conexao->query("select * from apolice ".$query);
			$array = $stat->fetchAll(PDO::FETCH_CLASS, 'Apolice');
			return $array;
		} catch (PDOException $e) {
			echo "Erro ao filtrar apólice!".$e;
		}//catch
	}//filtrar cliente

	public function alterarApolice($apo){
		try{
			$stat = $this->conexao->prepare("update apolice set valor = ?, registro_veiculo = ?, id_cliente = ? where numero = ?");
			$stat->bindValue(1, $apo->valor);
			$stat->bindValue(2, $apo->registroVeiculo);
			$stat->bindValue(3, $apo->idCliente);
			$stat->bindValue(4, $apo->numero);
			$stat->execute();
		}catch(PDOException $e){
			echo "Erro ao alterar apolice!" . $e;
		}//catch
	}//alterarCliente
}//fecha classe
