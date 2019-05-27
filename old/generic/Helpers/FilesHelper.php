<?php
class FilesHelper
{
  /**
   * ConstructFileName
   *
   * @param mixed $nameParameters
   * @param mixed $extension
   * @static
   * @access public
   * @return void
   */
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

  /**
   * GetExtension
   *
   * @param mixed $string
   * @static
   * @access public
   * @return void
   */
  public static function GetExtension($string)
  {
    $nameExt = explode(".", $string);
    $nameExt = end($nameExt);
    return $nameExt;
  }

  /**
   * GetDir
   *
   * @param mixed $dir
   * @static
   * @access public
   * @return void
   */
  public static function GetDir($dir)
  {
    return $_SERVER['DOCUMENT_ROOT']."/".$dir;
  }

  /**
   * ListFilesFromDir
   *
   * @param mixed $dir
   * @static
   * @access public
   * @return void
   */
  public static function ListFilesFromDir($dir)
  {
    //return asc
    $files = scandir($dir, 1);
    $filesWithoutDirectory = $files;

    foreach($files as $key => $file)
    {
      //remove files without extensions and current and parent dir
      if(count(explode(".", $file)) == 1 || $file == '.' || $file == '..')
      {
        unset($filesWithoutDirectory[$key]);
      }
    }
    return $filesWithoutDirectory;
  }
}
