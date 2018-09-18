<?php
class Padronizacao {

  public static function padronizarMaiMin($v){
    return ucwords(mb_strtolower($v));
  }

  public static function padronizarUF($v){
    return strtoupper($v);
  }

  public static function padronizarValor($v){
    return "R$ ".$v;
  }

  public static function padronizarValorAlterar($v){
    return str_replace("R$ R$", "R$", $v);
  }

  public static function padronizarData($v){
    return date('Y-m-d', strtotime($v));
  }

  public static function padronizarDataBR($v){
    return date('d-m-Y', strtotime($v));
  }

  public static function padronizarHorario($v){
    return date('H:i', strtotime($v));
  }
}//fecha classe padronizacao
