<?php
require_once 'helpers/ReturnResponse.php';
require_once 'helpers/PicturesProcessor.php';
require_once 'clases/Alumno.php';
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
      return CrearAlumnoCsv($parameters);
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
  if(DaoMysql::GetByIdentifier($alumno->legajo))
  {
    $response = ModificarAlumno($alumno, "mysql");
  }
  else
  {
    $success = DaoMysql::Create($alumno);
    if($success)
    {
      $response = ReturnResponse::Response("create", true, 708, $alumno);
    }
    else
    {
      $response = ReturnResponse::Response("create", false, 707, null);
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
  if(DaoJson::GetByIdentifier($alumno->legajo))
  {
    $response = ModificarAlumno($alumno, "json");
  }
  else
  {
    $success = DaoJson::Create($alumno);
    if($success)
    {
      $response = ReturnResponse::Response("create", true, 708, $alumno);
    }
    else
    {
      $response = ReturnResponse::Response("create", false, 707, null);
    }
  }

  return $response;
}

function CrearAlumnoCsv($parameters)
{
  $response = null;

  $alumno = new Alumno();
  $alumno->SetParams($parameters);
  if(!is_null($alumno->foto))
    $alumno->foto = PicturesProcessor::UploadProfilePicture($parameters["foto"], $alumno->nombre,$alumno->legajo);

  //Si hay alumno con ese legajo, modificarlo
  if(DaoCsv::GetByIdentifier($alumno->legajo))
  {
    $response = ModificarAlumno($alumno, "csv");
  }
  else
  {
    $success = DaoCsv::Create($alumno);
    if($success)
    {
      $response = ReturnResponse::Response("create", true, 708, $alumno);
    }
    else
    {
      $response = ReturnResponse::Response("create", false, 707, null);
    }
  }

  return $response;
}
