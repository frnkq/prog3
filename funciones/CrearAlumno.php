<?php
require_once 'clases/Alumno.php';


function CrearAlumno($nombre, $edad, $dni, $legajo)
{
  $fileName = "alumnos.json";

  $alumno = new Alumno($nombre, $edad, $dni, $legajo);

  $alumnos = array();

  if(file_exists($fileName))
  {
    $alumnos = (array) json_decode(file_get_contents($fileName));
  }
  foreach($alumnos as $al)
  {
    if($al->legajo === $legajo)
    {
      $result = array(
        'Result' => "false",
        'ErrorCode' => "Un alumno con ese legajo ya existe"
      );
      echo json_encode($result);
      die();
    }

  }
  array_push($alumnos, $alumno);

  file_put_contents($fileName, json_encode($alumnos));

  $result = array(
    'Result' => "true",
    'Alumno' => json_decode($alumno->RetornarJson())
  );
  echo json_encode($result, true);
  die();
}
