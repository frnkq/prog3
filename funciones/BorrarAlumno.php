<?php
require_once 'clases/Alumno.php';

require_once 'helpers/AppConfig.php';
require_once 'helpers/FilesHelper.php';
//
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
      return BorrarAlumnoCsv($alumnoToDelete);
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
    $response = ReturnResponse::Response("delete", true, 706, $alumnoBefore);
  }
  else
  {
    $response = ReturnResponse::Response("delete", false, 705, null);
  }
  return $response;
}

function BorrarAlumnoJson($alumnoToDelete)
{
  $alumnoToDelete = Alumno::StdToAlumno($alumnoToDelete);

  $deletedAlumno = DaoJson::Delete($alumnoToDelete);

  if(is_null($deletedAlumno))
  {
    $response = ReturnResponse::Response("update", false, 705, null);
  }

  $response = ReturnResponse::Response("update", true, 706, $deletedAlumno);

  return $response;
}

function BorrarAlumnoCsv($alumnoToDelete)
{
  $alumnoToDelete = Alumno::StdToAlumno($alumnoToDelete);

  $deletedAlumno = DaoCsv::Delete($alumnoToDelete);

  if(is_null($deletedAlumno))
  {
    $response = ReturnResponse::Response("delete", false, 705, null);
  }

  $response = ReturnResponse::Response("delete", true, 706, $deletedAlumno);

  return $response;
}
