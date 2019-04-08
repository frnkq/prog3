<?php
class FilesHelper
{
  public static function ConstructFileName($nameParameters, $extension)
  {
    $finalName = "";
    foreach($nameParameters as $key => $nameParameter)
    {
      $finalName .= $nameParameter;
      if($key == count($nameParameters)-1)
        break;
      $finalName .= "_";
    }
    $finalName .= ".".$extension;
    return $finalName;
  }

  public static function GetExtension($string)
  {
    $nameExt = explode(".", $string);
    $nameExt = end($nameExt);
    return $nameExt;
  }

  public static function GetDir($dir)
  {
    return $_SERVER['DOCUMENT_ROOT']."/".$dir;
  } 
}
