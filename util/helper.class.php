<?php
class Helper{
  public static function alert($msg){
    echo "<script>";
    echo "alert('$msg')";
    echo "</script>";
  }

  public static function h2($msg){
    echo "<h2 class='text-light'>$msg</h2>";
  }
}//fecha class
