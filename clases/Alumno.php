<?php

include_once 'Persona.php';

class Alumno extends Persona
{
  public $legajo;

  function __construct($parameters)
  {
    if($parameters != null)
    {
      $nombre = array_key_exists("nombre", $parameters) ? $parameters["nombre"] : "noname";
      $edad = array_key_exists("edad", $parameters) ? $parameters["edad"] : 0;
      $dni = array_key_exists("dni", $parameters) ? $parameters["dni"] : 0;
      $apellido = array_key_exists("apellido", $parameters) ? $parameters["apellido"] : "nosurname";
      $legajo = array_key_exists("legajo", $parameters) ? $parameters["legajo"] : 0;

      parent::__construct($nombre, $edad, $dni, $apellido);

      $this->legajo = $legajo;

      if(array_key_exists("foto", $parameters))
        $this->foto = $parameters["foto"];
    }
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
    $tableRow .="<td>$this->edad</td>";
    $tableRow .="<td>$this->apellido</td>";
    $tableRow .="<td>$this->dni</td>";
    if(!is_null($this->foto))
    {
      $tableRow .="<td><img src='$this->foto' height='48' width='48' alt='ProfilePicture'/></td>";
    }
    return $tableRow;
  }

  public static function PrintAlumno($alumno)
  {
    return
      "
        <ul>
          <li>Nombre: ".$alumno->nombre."</li>
          <li>Edad: ".$alumno->edad."</li>
          <li>Dni: ".$alumno->dni."</li>
          <li>Legajo: ".$alumno->legajo."</li>
        </ul>
      ";
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

      return new Alumno($parameters);
    }
  }

}
