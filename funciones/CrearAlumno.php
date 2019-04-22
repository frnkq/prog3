<?php
require_once 'helpers/ReturnResponse.php';
require_once 'helpers/PicturesProcessor.php';
require_once 'clases/Alumno.php';
require_once 'clases/AlumnoDAO.php';
require_once 'funciones/ModificarAlumno.php';

function CrearAlumno($parameters)
{
  $response = null;

  $alumno = new Alumno();
  $alumno->SetParams($parameters);
  if(!is_null($alumno->foto))
    $alumno->foto = PicturesProcessor::UploadProfilePicture($parameters["foto"], $alumno->nombre,$alumno->legajo);

  //Si hay alumno con ese legajo, modificarlo
  if(AlumnoDAO::GetAlumnoByLegajo($alumno->legajo))
  {
    $response = ModificarAlumno($alumno);
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

