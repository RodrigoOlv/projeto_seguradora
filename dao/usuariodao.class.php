<?php
require_once "conexaobanco.class.php";

class UsuarioDAO {

	private $conexao = null;

	public function __construct(){
		$this->conexao = ConexaoBanco::getInstance();
	}

	public function __destruct(){}

  public function filtrarUsuario($query){
    try {
      $stat = $this->conexao->query("select * from usuario ".$query);
      $array = $stat->fetchAll(PDO::FETCH_CLASS, 'Usuario');
      return $array;
    } catch (PDOException $e) {
      echo "Erro ao fazer login!".$e;
    }//catch
  }//filtrar
}//class
