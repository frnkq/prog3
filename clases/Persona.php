<?php
class Persona
{
  public $nombre;
  public $edad;
  public $dni;

  function __construct($nombre, $edad, $dni)
  {
    $this->nombre = $nombre;
    $this->edad = $edad;
    $this->dni = $dni;
  }

  public function RetornarJson()
  {
    return json_encode($this);
  }
}
