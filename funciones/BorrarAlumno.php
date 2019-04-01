<?php
require_once 'clases/Alumno.php';

function BorrarAlumno($legajo)
{
  $alumnos = array();

  $fileName = "alumnos.json";
  if(file_exists($fileName))
  {
    $alumnos = (array) json_decode(file_get_contents($fileName));
  }

  $alumnosCopy = $alumnos;
  $result = null;
  foreach($alumnos as $key => $alumno)
  {
    if($alumno->legajo === $legajo)
    {
      unset($alumnosCopy[$key]);
      $result = array(
        'Result' => "true",
        'Alumno' => 
        json_decode(
          (new Alumno($alumno->nombre, $alumno->edad, $alumno->dni, $alumno->legajo)
        )->RetornarJson()));
    }
    else
    {
      $result = array(
        'Result' => "false",
        'Alumno' => null
      );
    }
  }
  echo json_encode($result);
  file_put_contents($fileName, json_encode($alumnosCopy));
  die();
}
