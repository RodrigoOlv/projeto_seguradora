<?php
class Acidente {

	private $codigoSinistro;
	private $localSinistro;
	private $dataSinistro;
	private $horario;
	private $registroVeiculo;

	public function __construct(){}
	public function __destruct(){}

	public function __get($atrib){
		return $this->$atrib;
	}

	public function __set($atrib, $valor){
		$this->$atrib = $valor;
	}

	public function __toString(){
		return nl2br("Código do Sinistro: $this->codigoSinistro
					Local: $this->localSinistro
					Data: $this->dataSinistro
					Horario: $this->horario
					Registro do Veículo: $this->registroVeiculo");
	}
}
