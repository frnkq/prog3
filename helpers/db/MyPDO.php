<?php

include_once('helpers/AppConfig.php');

class MyPDO
{
  private static $PDObject;
  private $objetoPDO;

  private function __construct()
  {
    try
    {
      $host = AppConfig::$db["host"];
      $username = AppConfig::$db["username"];
      $password = AppConfig::$db["password"];
      $dbname = AppConfig::$db["dbname"];
      $this->objetoPDO = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password,
        array(PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
      );
      $this->objetoPDO->exec("SET CHARACTER SET utf8");
    }
    catch(PDOException $e)
    {
      echo "PDO error: ".$e->getMessage();
      die();
    }
  }

  public function GetPdo()
  {
    if(!isset(self::$PDObject))
    {
      self::$PDObject = new MyPDO();
    }
    return self::$PDObject;
  }

  public function __clone()
  {
    triger_error("La clonacion de este objeto no esta permitida", E_USER_ERROR);
  }

  public function ReturnQuery($sql)
  {
    return $this->objetoPDO->prepare($sql);
  }

}
