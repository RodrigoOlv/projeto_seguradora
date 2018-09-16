<?php
require_once "conexaobanco.class.php";

class AcidenteDAO {

	private $conexao = null;

	public function __construct(){
		$this->conexao = ConexaoBanco::getInstance();
	}

	public function __destruct(){}

	public function cadastrarAcidente($aci){
		try{
			$stat = $this->conexao->prepare("insert into acidente(codigo_sinistro, local_sinistro, data_sinistro, horario, registro_veiculo) VALUES(null, ?, ?, ?, ?)");
			$stat->bindValue(1, $aci->localSinistro);
			$stat->bindValue(2, $aci->dataSinistro);
			$stat->bindValue(3, $aci->horario);
      $stat->bindValue(4, $aci->registroVeiculo);
			$stat->execute();
		}catch(PDOException $e){
			echo "Erro ao cadastrar acidente!" . $e;
		}//catch
	}//cadastrar veiculo

	public function buscarAcidente(){
    try{
      $stat = $this->conexao->query("select * from acidente");
      $array = $stat->fetchAll(PDO::FETCH_CLASS,'Acidente');
      return $array;
    }catch(PDOException $e){
      echo "Erro ao buscar acidentes! ".$e;
    }//catch
  }//buscarCliente

	public function deletarAcidente($codigo_sinistro){
    try{
      $stat = $this->conexao->prepare("delete from acidente where codigo_sinistro = ?");
      $stat->bindValue(1, $codigo_sinistro);
      $stat->execute();
    }catch(PDOException $e){
      echo "Erro ao excluir acidente! ".$e;
    }//catch
  }//deletar cliente

	public function filtrarAcidente($query){
		try {
			$stat = $this->conexao->query("select * from acidente ".$query);
			$array = $stat->fetchAll(PDO::FETCH_CLASS, 'Acidente');
			return $array;
		} catch (PDOException $e) {
			echo "Erro ao filtrar acidente!".$e;
		}//catch
	}//filtrar cliente

	public function alterarAcidente($aci){
		try{
			$stat = $this->conexao->prepare("update acidente set local_sinistro = ?, data_sinistro = ?, horario = ?, registro_veiculo = ? where codigo_sinistro = ?");
			$stat->bindValue(1, $aci->localSinistro);
			$stat->bindValue(2, $aci->dataSinistro);
			$stat->bindValue(3, $aci->horario);
			$stat->bindValue(4, $aci->registroVeiculo);
      $stat->bindValue(5, $aci->codigoSinistro);
			$stat->execute();
		}catch(PDOException $e){
			echo "Erro ao alterar acidente!" . $e;
		}//catch
	}//alterarCliente
}//fecha classe
