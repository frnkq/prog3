<?php
require_once 'clases/Alumno.php';

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

      $result = array(
        'Result' => "false",
        'AlumnoOld' => $alumno,
        'AlumnoNew' => $newAlumno
      );
      $found = true;
      break;
    }

    if(!$found)
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
