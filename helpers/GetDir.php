<?php
class GetDir
{
  public static function Get($dir)
  {
    return $_SERVER['DOCUMENT_ROOT']."/".$dir;
  } 
}
