<?php
require_once 'clases/Alumno.php';
require_once 'helpers/ReturnResponse.php';

function BorrarAlumno($legajo)
{
  $fileName = "alumnos.json";
  $alumnos = array();
  $result = null;

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
      $result = ReturnResponse(true, null, $alumno);
      break;
    }
    else
    {
      $result = ReturnResponse(false, null, null);
    }
  }

  echo $result;
  file_put_contents($fileName, json_encode($alumnosCopy));
}
