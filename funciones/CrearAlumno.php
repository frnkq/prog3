<?php
require_once 'helpers/ReturnResponse.php';
require_once 'helpers/PicturesProcessor.php';
require_once 'clases/Alumno.php';
require_once 'clases/AlumnoDAO.php';
require_once 'funciones/ModificarAlumno.php';
//crearalumnojson llame a modificaralumnojson si existe
function CrearAlumno($parameters, $format)
{
  switch($format)
  {
    case "mysql":
      return CrearAlumnoMysql($parameters);
      break;

    case "json":
      return CrearAlumnoJson($parameters);
      break;

    case "csv":

      break;
  }
}
function CrearAlumnoMysql($parameters)
{
  $response = null;

  $alumno = new Alumno();
  $alumno->SetParams($parameters);
  if(!is_null($alumno->foto))
    $alumno->foto = PicturesProcessor::UploadProfilePicture($parameters["foto"], $alumno->nombre,$alumno->legajo);

  //Si hay alumno con ese legajo, modificarlo
  if(AlumnoDAO::GetAlumnoByLegajo($alumno->legajo))
  {
    $response = ModificarAlumno($alumno, "mysql");
  }
  else
  {
    $success = AlumnoDao::SaveAlumno($alumno);
    if($success)
    {
      $response = ReturnResponse::Response(AppConfig::$apiActions['create'],
        true, 708, $alumno);
    }
    else
    {
      $response = ReturnResponse::Response(AppConfig::$apiActions['create'],
        false, 707, null);
    }
  }

  return $response;
}

function CrearAlumnoJson($parameters)
{
  $response = null;

  $alumno = new Alumno();
  $alumno->SetParams($parameters);
  if(!is_null($alumno->foto))
    $alumno->foto = PicturesProcessor::UploadProfilePicture($parameters["foto"], $alumno->nombre,$alumno->legajo);

  //Si hay alumno con ese legajo, modificarlo
  if(AlumnoDAOFiles::GetAlumnoByLegajo("json", $alumno->legajo))
  {
    $response = ModificarAlumno($alumno, "json");
  }
  else
  {
    $success = AlumnoDaoFiles::SaveAlumno($alumno, "json");
    if($success)
    {
      $response = ReturnResponse::Response(AppConfig::$apiActions['create'],
        true, 708, $alumno);
    }
    else
    {
      $response = ReturnResponse::Response(AppConfig::$apiActions['create'],
        false, 707, null);
    }
  }

  return $response;
}
