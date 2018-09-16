<?php
class Apolice {

	private $numero;
	private $valor;
	private $registroVeiculo;
	private $idCliente;

	public function __construct(){}
	public function __destruct(){}

	public function __get($atrib){
		return $this->$atrib;
	}

	public function __set($atrib, $valor){
		$this->$atrib = $valor;
	}

	public function __toString(){
		return nl2br("Número da Apólice: $this->numero
					Valor da Apólice: $this->valor");
	}
}
