<?php
require_once 'clases/Alumno.php';
require_once 'clases/AlumnoDAO.php';

require_once 'helpers/AppConfig.php';
require_once 'helpers/FilesHelper.php';

function BorrarAlumno($alumnoToDelete)
{
  $alumno = Alumno::StdToAlumno($alumnoToDelete);
  $alumnoBefore = AlumnoDAO::GetAlumnoByLegajo($alumno->legajo);
  $success = AlumnoDAO::DeleteAlumnoByLegajo($alumno->legajo);

  if($success)
  {
    $response = ReturnResponse::Response(AppConfig::$apiActions['delete'],
      true, 706, $alumnoBefore);
  }
  else
  {
    $response = ReturnResponse::Response(AppConfig::$apiActions['update'], 
    false, 705, null);
  }
  return $response;
}

function BorrarAlumnoJson($alumnoToDelete)
{
  $alumnoToDelete = Alumno::StdToAlumno($alumnoToDelete);
  $alumnos = AlumnoDao::GetAlumnosFromJson(AppConfig::$alumnosJsonFileName);
  $alumnosCopy = $alumnos;
  $deleted = false;
  foreach($alumnos as $key => $alumno)
  {
    $alumno = Alumno::StdToAlumno($alumno);
    if($alumno->legajo === $alumnoToDelete->legajo)
    {
      unset($alumnosCopy[$key]);
      $deleted = true;
      break;
    }
  }
  if($deleted)
  {
    AlumnoDao::SaveAlumnos(FilesHelper::GetDir(AppConfig::$alumnosJsonFileName), $alumnosCopy);
    echo "alumno eliminado";
  }
  else
  {
    echo "alumno no eliminado";
  }
}
