<?php
class Cliente {

	private $id;
	private $nome;
	private $sobrenome;
	private $cpf;
	private $telefone;
	private $logradouro;
	private $numero;
	private $cep;
	private $bairro;
	private $cidade;
	private $uf;

	public function __construct(){}
	public function __destruct(){}

	public function __get($atrib){
		return $this->$atrib;
	}

	public function __set($atrib, $value){
		$this->$atrib = $value;
	}


	public function __toString() {
	
		$nomeCompleto = $this->nome . " " . $this->sobrenome;
		$endereco = $this->logradouro . ", " . $this->numero . " - " . $this->bairro . ", " . $this->cidade . " - " . $this->uf;

		return nl2br("Código: $this->id
					Nome: $nomeCompleto
					CPF: $this->cpf
					Telefone: $this->telefone
					Endereço: $endereco
					CEP: $this->cep");
	}
}