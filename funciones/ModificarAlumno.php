<?php
require_once 'clases/Alumno.php';
require_once 'helpers/ReturnResponse.php';

function ModificarAlumno($legajo, $parameters)
{
  $alumnos = array();

  $fileName = "alumnos.json";

  if(file_exists($fileName))
  {
    $alumnos = (array) json_decode(file_get_contents($fileName));
  }

  $alumnosCopy = $alumnos;
  $result = null;
  $found = false;
  foreach($alumnos as $key => $alumno)
  {
    if($alumno->legajo == $legajo)
    {
      $legajo = $alumno->legajo;
      $nombre = (isset($parameters['nombre'])) ? $parameters['nombre'] : $alumno->nombre;
      $edad = (isset($parameters['edad'])) ? $parameters['edad'] : $alumno->edad;
      $dni = (isset($parameters['dni'])) ? $parameters['dni'] : $alumno->dni;

      $newAlumno = new Alumno($nombre, $edad, $dni, $legajo);
      $alumnosCopy[$key] = $newAlumno;

      $result = ReturnResponse(true, null, array($alumno, $newAlumno));
      $found = true;
      break;
    }

    if(!$found)
    {
      $result = ReturnResponse(false, "Alumno no encontrado", null);
    }
  }

  file_put_contents($fileName, json_encode($alumnosCopy));

  echo $result;
  die();
}
