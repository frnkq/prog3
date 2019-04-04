<?php
require_once 'helpers/AppConfig.php';
require_once 'clases/AlumnoDAO.php';
require_once 'clases/Alumno.php';
require_once 'helpers/ReturnResponse.php';

function BorrarAlumno($alumnoToDelete)
{

  $alumnoToDelete = Alumno::StdToAlumno($alumnoToDelete);
  $alumnos = AlumnoDao::GetAlumnosFromJson(AppConfig::$alumnosJsonFileName);
  $alumnosCopy = $alumnos;

  $result = null;

  foreach($alumnos as $key => $alumno)
  {
    $alumno = Alumno::StdToAlumno($alumno);
    
    if($alumno->legajo === $alumnoToDelete->legajo)
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
  file_put_contents(AppConfig::$alumnosJsonFileName, json_encode($alumnosCopy));
}
