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

  public function ToString()
  {
    return
      "
        <ul>
          <li>Nombre: ".$this->nombre."</li>
          <li>Edad: ".$this->edad."</li>
          <li>Dni: ".$this->dni."</li>
          <li>Legajo: ".$this->legajo."</li>
        </ul>
      ";
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
