
<?php

class AppConfig
{

  public static $profilePicturesDir = "fotos";
  public static $profilePicturesBackupDir = "fotosBackup";
  public static $resourcesDir = "resources";

  public static $jsonFilename = "alumnos.json";
  public static $csvFilename = "alumnos.csv";
  public static $csvSeparator = ";";
  public static $csvAlumnoHeader = "legajo;nombre;apellido;edad;dni;foto\n";

  public static $db = array(
    "host" => "somehost",
    "username" => "someuser",
    "password" => "somepass",
    "dbname" => "somedb"
  );

  public static function GetReturnFormat()
  {
    return "json";
  }

  public static function isHtmlClient()
  {
    return (self::GetReturnFormat() == "html") ? true : false;
  }
}
