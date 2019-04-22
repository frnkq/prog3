<?php
require_once 'helpers/ReturnResponse.php';
require_once 'helpers/PicturesProcessor.php';
require_once 'clases/Alumno.php';
require_once 'clases/AlumnoDAO.php';

function CrearAlumno($parameters)
{
  $fileName = AppConfig::$alumnosJsonFileName;

  $alumno = new Alumno();
  $alumno->SetParams($parameters);
  if(!is_null($alumno->foto))
    $alumno->foto = PicturesProcessor::UploadProfilePicture($parameters["foto"], $alumno->nombre,$alumno->legajo);

  //Si hay alumno con ese legajo, modificarlo
  if(!is_null(AlumnoDAO::GetAlumnoByLegajo($alumno->legajo)))
  {
    AlumnoDAO::UpdateAlumno($alumno);
    return $alumno;
  }

  AlumnoDao::SaveAlumno($alumno);
  echo ReturnResponse(true, null, $alumno);
  return $alumno;
}

