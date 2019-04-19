<?php
class Persona
{
  public $nombre;
  public $edad;
  public $dni;
  public $apellido; 
  
 // function __construct($nombre, $edad, $dni, $apellido)
 // {
 //   $this->nombre = $nombre;
 //   $this->edad = $edad;
 //   $this->dni = $dni;
 //   $this->apellido = $apellido;
 // }
  public function RetornarJson()
  {
    return json_encode($this);
  }
}
