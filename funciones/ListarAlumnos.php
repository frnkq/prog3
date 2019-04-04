<?php
require_once 'clases/Alumno.php';
require_once 'helpers/ReturnResponse.php';

function GetAlumnosFromJson($fileName)
{
  $alumnos = array();

  if(file_exists($fileName))
  {
    $alumnos = (array) json_decode(file_get_contents($fileName));
  }
  return $alumnos;
}

function ListarAlumnos()
{
  $fileName = "alumnos.json";
  $returnString = "";

  $alumnos = GetAlumnosFromJson($fileName);

  if(!is_null($alumnos))
  {
      foreach($alumnos as $al)
      {
        $alumno = new Alumno(json_decode(json_encode($al), true)); 
        $returnString = $returnString.$alumno->ToString();
      }

      return $returnString;
  }
  else
  {
    return "No hay alumnos";
  }

}

function ListarAlumno($legajo)
{
  $fileName = "alumnos.json";
  $alumnos = GetAlumnosFromJson($fileName);
  $found = false;
  foreach($alumnos as $alumno)
  {
    if($alumno->legajo == $legajo)
    {
      $found = true;
      return new Alumno($alumno->nombre, $alumno->edad, $alumno->dni, $alumno->legajo);
    }
  }
  if(!$found) return null;
}
