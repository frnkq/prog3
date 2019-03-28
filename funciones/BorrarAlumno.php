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

  foreach($alumnos as $key => $alumno)
  {
    if($alumno->legajo === $legajo)
    {
      unset($alumnosCopy[$key]);
    }
  }
  var_dump($alumnosCopy);
  die();
}
