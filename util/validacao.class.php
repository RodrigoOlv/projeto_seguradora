<?php
class Validacao {

  public static function validarNome($v){
    $exp = "/^[A-zÁ-ù ]{2,50}$/";
    return preg_match($exp, $v);
  }

  public static function validarSobrenome($v){
    $exp = "/^[A-zÁ-ùü ]{2,50}$/";
    return preg_match($exp, $v);
  }

  public static function validarLogradouro($v){
    $exp = "/^[A-zÁ-ù ]{2,50}$/";
    return preg_match($exp, $v);
  }

  public static function validarBairro($v){
    $exp = "/^[A-zÁ-ù ]{2,50}$/";
    return preg_match($exp, $v);
  }

  public static function validarCidade($v){
    $exp = "/^[A-zÁ-ù ]{2,50}$/";
    return preg_match($exp, $v);
  }

  public static function validarCPF($cpf){
    // Verifica se um número foi informado
  	if(empty($cpf)) {
  		return false;
  	}

  	// Elimina possivel mascara
  	$cpf = preg_replace("/[^0-9]/", "", $cpf);
  	$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

  	// Verifica se o numero de digitos informados é igual a 11
  	if (strlen($cpf) != 11) {
  		return false;
  	}
  	// Verifica se nenhuma das sequências invalidas abaixo
  	// foi digitada. Caso afirmativo, retorna falso
  	else if ($cpf == '00000000000' ||
  		$cpf == '11111111111' ||
  		$cpf == '22222222222' ||
  		$cpf == '33333333333' ||
  		$cpf == '44444444444' ||
  		$cpf == '55555555555' ||
  		$cpf == '66666666666' ||
  		$cpf == '77777777777' ||
  		$cpf == '88888888888' ||
  		$cpf == '99999999999') {
  		return false;
  	 // Calcula os digitos verificadores para verificar se o
  	 // CPF é válido
  	 } else {

  		for ($t = 9; $t < 11; $t++) {

  			for ($d = 0, $c = 0; $c < $t; $c++) {
  				$d += $cpf{$c} * (($t + 1) - $c);
  			}
  			$d = ((10 * $d) % 11) % 10;
  			if ($cpf{$c} != $d) {
  				return false;
  			}
  		}

  		return $cpf;
  	}
  }//validar cpf

  public static function validarTelefone($v){
    $exp = "/^\(?\d{2}\)?[\s-]?\d{4,5}-?\d{4}$/";
    return preg_match($exp, $v);
  }//validar telefone

  public static function validarNumero($v){
    $exp = "/^[\d]{1,5}$/";
    return preg_match($exp, $v);
  }//validar numero

  public static function validarCEP($v){
    $exp = "/^([\d]{8}|[\d]{5}-[\d]{3})$/";
    return preg_match($exp, $v);
  }//validar cep

  public static function validarUF($v){
    $exp = "/^(PR|RS|SC)$/";
    return preg_match($exp, $v);
  }

  public static function antiXSS($v){
    return htmlspecialchars(trim($v));
  }

  public static function validarMarca($v){
    $exp = "/^[A-zÁ-ùü ]{2,50}$/";
    return preg_match($exp, $v);
  }

  public static function validarModelo($v){
    $exp = "/^[A-zÁ-ùü ]{2,50}$/";
    return preg_match($exp, $v);
  }

  public static function validarPlaca($v){
    $exp = "/^([A-Z]{3}-[\d]{4}|[A-Z]{3}[\d]{4})$/";
    return preg_match($exp, $v);
  }

  public static function validarValor($v){
    $exp = "/^([\d]{1,8},[\d]{0,2}|[\d]{1,8})$/";
    return preg_match($exp, $v);
  }

  public static function validarValorAlterar($v){
    $exp = "/^([R$ ]{3}[\d]{1,8},[\d]{0,2}|[R$ ]{3}[\d]{1,8})$/";
    return preg_match($exp, $v);
  }

  public static function validarFK($v){
    $exp = "/^[\d]+$/";
    return preg_match($exp, $v);
  }

  public static function validarLocal($v){
    $exp = "/^[A-zÁ-ù\d,- ]{2,100}$/";
    return preg_match($exp, $v);
  }

  public static function validarData($v){
    $exp = "/^\d{4}-(0[1-9]|1[0,1,2])-(0[1-9]|[1,2][0-9]|3[0,1])$/";
    return preg_match($exp, $v);
  }

  public static function validarHorario($v){
    $exp = "/^([0-1][0-9]|[2][0-3])(:([0-5][0-9])){1,2}$/";
    return preg_match($exp, $v);
  }
}//fecha class
