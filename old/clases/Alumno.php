<?php

include_once 'Persona.php';
include_once 'helpers/AppConfig.php';

class Alumno extends Persona
{
  public $legajo;
  public $foto;

  public function SetParams($parameters)
  {
    if($parameters != null)
    {
      $nombre = array_key_exists("nombre", $parameters) ? $parameters["nombre"] : "noname";
      $edad = array_key_exists("edad", $parameters) ? $parameters["edad"] : 0;
      $dni = array_key_exists("dni", $parameters) ? $parameters["dni"] : 0;
      $apellido = array_key_exists("apellido", $parameters) ? $parameters["apellido"] : "nosurname";
      $legajo = array_key_exists("legajo", $parameters) ? $parameters["legajo"] : 0;

      $this->nombre = $nombre;
      $this->edad = $edad;
      $this->dni = $dni;
      $this->apellido = $apellido;
      $this->legajo = $legajo;

      if(array_key_exists("foto", $parameters))
        $this->foto = $parameters["foto"];
      else
        $this->foto = null;
    }

  }

  public static function CsvToAlumno($csvLine)
  {
    $parameters = array(
      "legajo" => $csvLine[0],
      "nombre" => $csvLine[1],
      "apellido" => $csvLine[2],
      "edad" => $csvLine[3],
      "dni" => $csvLine[4],
      "foto" => $csvLine[5]
    );
    $alumno = new Alumno();
    $alumno->SetParams($parameters);
    return $alumno;
  }

  public static function ToCsv($alumno)
  {
      $sep = AppConfig::$csvSeparator;
      $str = $alumno->legajo."".$sep;
      $str .= $alumno->nombre."".$sep;
      $str .= $alumno->apellido."".$sep;
      $str .= $alumno->edad."".$sep;
      $str .= $alumno->dni."".$sep;
      $str .= $alumno->foto;
      return $str;
  }

  public static function CreateHTMLTable($content)
  {
    $tableHeader = "<table border='1px'><thead>";
    $tableHeader .= "<tr>";
    $tableHeader .= "<td>Legajo</td>";
    $tableHeader .= "<td>Nombre</td>";
    $tableHeader .= "<td>Apellido</td>";
    $tableHeader .= "<td>Edad</td>";
    $tableHeader .= "<td>DNI</td>";
    $tableHeader .= "<td>Foto</td>";
    $tableContent = $content;
    $tableFooter = "</table>";

    $table = $tableHeader.$tableContent.$tableFooter;
    return $table;
  }

  public function ToString()
  {
    $tableRow = "<tr>";
    $tableRow .="<td>$this->legajo</td>";
    $tableRow .="<td>$this->nombre</td>";
    $tableRow .="<td>$this->apellido</td>";
    $tableRow .="<td>$this->edad</td>";
    $tableRow .="<td>$this->dni</td>";
    if(!is_null($this->foto))
    {
      $tableRow .="<td><img src='".AppConfig::$profilePicturesDir."/$this->foto' height='48' width='48' alt='ProfilePicture'/></td>";
    }
    return $tableRow;
  }


  public static function StdToAlumno($object)
  {
    $nombre = null;
    $edad = null;
    $dni = null;
    $legajo = null;
    $foto = null;
    $apellido = null;
    if(is_array($object))
    {
      if(array_key_exists("nombre", $object))
        $nombre = $object["nombre"];
      if(array_key_exists("edad", $object))
        $edad = $object["edad"];
      if(array_key_exists("dni", $object))
        $dni = $object["dni"];
      if(array_key_exists("legajo", $object))
        $legajo = $object["legajo"];
      if(array_key_exists("foto", $object))
        $foto = $object["foto"];
      if(array_key_exists("apellido", $object))
        $apellido = $object["apellido"];

      $parameters = array(
        "nombre" => $nombre,
        "edad" => $edad,
        "dni" => $dni,
        "legajo" => $legajo,
        "foto" => $foto,
        "apellido" => $apellido
      );

      $alumno = new Alumno();
      $alumno->SetParams($parameters);
      return $alumno;
    }
  }

}
