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
}
