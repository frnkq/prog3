<?php
class ViewHelper
{
  public static function CreateRows($array)
  {
    $str = "";
    //in this example $array = listof pictures files in dir
    foreach($array as $row)
    {
      $str .= "<tr>";
      $str .= "<td>$row</td>";
      $str .= "<td><img height=200 width=200 src=".AppConfig::$profilePicturesBackupDir."/$row /></td>";
      $str .= "</tr>";
    }
    return $str;
  }

  public static function CreateHtmlTable($content)
  {
    $tableHeader = "<table border='1px'><thead>";
    $tableHeader .= "<tr>";
    $tableHeader .= "<td>Archivo</td>";
    $tableHeader .= "<td>Foto</td>";
    $tableHeader .= "</tr>";
    $tableContent = "<tbody>";
    $tableContent .= self::CreateRows($content);
    $tableFooter = "</tbody>";
    $tableFooter = "</table>";

    $table = $tableHeader.$tableContent.$tableFooter;
    return $table;

  }
}
