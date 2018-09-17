<?php
class Usuario{

  private $id;
  private $login;
  private $senha;

  public function __construct(){}
  public function __destruct(){}

  public function __get($atrib){
    return $this->$atrib;
  }

  public function __set($atrib, $valor){
    $this->$atrib = $valor;
  }

  public function __toString(){
    return nl2br("ID: $this->id
                  Login: $this->login
                  Senha: $this->senha");
  }
}
