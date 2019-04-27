<?php
require_once 'clases/Alumno.php';
require_once 'clases/AlumnoDAO.php';

require_once 'helpers/AppConfig.php';
require_once 'helpers/FilesHelper.php';
//return response on json
function BorrarAlumno($alumnoToDelete, $source)
{
  switch($source)
  {
    case "mysql":
      return BorrarAlumnoMySql($alumnoToDelete);
      break;

    case "json":
      return BorrarAlumnoJson($alumnoToDelete);
      break;

    case "csv":

      break;
  }
}
function BorrarAlumnoMySql($alumnoToDelete)
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
  $alumnos = AlumnoDaoFiles::GetAlumnos("json");
  $alumnosCopy = $alumnos;
  $deleted = false;
  foreach($alumnos as $key => $alumno)
  {
    $alumno = Alumno::StdToAlumno($alumno);
    if($alumno->legajo === $alumnoToDelete->legajo)
    {
      unset($alumnosCopy[$key]); $deleted = true;
      break;
    }
  }
  if($deleted)
  {
    AlumnoDaoFiles::SaveAlumnos($alumnosCopy, "json");
    echo "alumno eliminado";
  }
  else
  {
    echo "alumno no eliminado";
  }
}
