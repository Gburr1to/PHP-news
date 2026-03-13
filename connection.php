<?php

//razred, ki skrbi za povezavo z bazo (Vzorec MVC zagovarja principe OOP)
class Db
{
  private static $instance = NULL;

  //Funkcija getInstance vrne povezavo z bazo. Ob prvem klicu ustvari povezavo in jo shrani v statični spremenljivki. 
  // Ob nadaljnjih klicih vrača povezavo iz spomina
  public static function getInstance()
  {
    if (!isset(self::$instance)) {
      $host = getenv('DB_HOST') ?: 'localhost';
      $user = getenv('DB_USER') ?: 'admin';
      $pass = getenv('DB_PASS');
      $db   = getenv('DB_NAME') ?: 'news';
      self::$instance = mysqli_connect($host, $user, $pass, $db);
      self::$instance->set_charset("UTF8");
    }
    return self::$instance;
  }
}
