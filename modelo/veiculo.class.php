<?php
class Veiculo {

	private $registro;
	private $marca;
	private $modelo;
	private $placa;

	public function __construct(){}
	public function __destruct(){}

	public function __get($atrib){
		return $this->$atrib;
	}

	public function __set($atrib, $valor){
		$this->$atrib = $valor;
	}

	public function __toString(){
		return nl2br("Registro: $this->registro
					Marca: $this->marca
					Modelo: $this->modelo
					Placa: $this->placa");
	}
}