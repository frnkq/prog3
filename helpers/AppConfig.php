<?php

class AppConfig
{
  //public static $alumnosJsonFileName = "alumnos.json";
  public static $jsonFilename = "alumnos.json";
  public static $csvFilename = "alumnos.csv";
  public static $csvSeparator = ";";
  public static $csvAlumnoHeader = "legajo;nombre;apellido;edad;dni;foto\n";

  public static $profilePicturesDir = "fotos";
  public static $profilePicturesBackupDir = "fotosBackup";
  public static $resourcesDir = "resources";

  public static $db = array(
    "host" => "localhost",
    "username" => "root",
    "password" => "frnkquito",
    "dbname" => "utn_alumnos"
  );

  public static function GetReturnFormat()
  {
    return "html";
  }

  public static function isHtmlClient()
  {
    return (self::GetReturnFormat() == "html") ? true : false;
  }
}
