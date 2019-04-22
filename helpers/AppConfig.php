<?php

class AppConfig
{
  public static $alumnosJsonFileName = "alumnos.json";
  public static $profilePicturesDir = "fotos";
  public static $profilePicturesBackupDir = "fotosBackup";
  public static $resourcesDir = "resources";

  public static $db = array(
    "host" => "localhost",
    "username" => "root",
    "password" => "frnkquito",
    "dbname" => "utn_alumnos"
  );

  public static $returnFormats = array(
    'html' => "html", 'json' => "json"
  );

  public static function GetReturnFormat()
  {
    return self::$returnFormats["json"];
  }

  public static function isHtmlClient()
  {
    if(self::GetReturnFormat() == AppConfig::$returnFormats["html"])
      return true;
    return false;
  }


  public static $apiActions = array(
    'get' => "get",
    'update' => "update",
    'delete' => "delete",
    'create' => "create"
  );
}
