<?php
require_once 'clases/Alumno.php';
require_once 'clases/AlumnoDAO.php';

require_once 'helpers/AppConfig.php';
require_once 'helpers/FilesHelper.php';

function BorrarAlumno($alumnoToDelete)
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
