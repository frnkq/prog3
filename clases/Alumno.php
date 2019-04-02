<?php


include_once 'Persona.php';

class Alumno extends Persona
{
  public $legajo;

  function __construct($nombre, $edad, $dni, $legajo)
  {
    parent::__construct($nombre, $edad, $dni);
    $this->legajo = $legajo;
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
}
