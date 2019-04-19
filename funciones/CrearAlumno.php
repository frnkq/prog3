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
  $alumno->foto = PicturesProcessor::UploadProfilePicture($parameters["foto"], $alumno->nombre,$alumno->legajo);
  AlumnoDao::SaveAlumno($alumno);
  echo ReturnResponse(true, null, $alumno);
  return $alumno;
}

