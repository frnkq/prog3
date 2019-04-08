<?php
require_once 'clases/Alumno.php';
require_once 'clases/AlumnoDAO.php';

require_once 'helpers/ReturnResponse.php';

function ListarAlumnos()
{
  $returnString = "";
  $alumnos = AlumnoDao::GetAlumnosFromJson(AppConfig::$alumnosJsonFileName);
  $rows = "";
  if(!is_null($alumnos))
  {
      foreach($alumnos as $al)
      {
        $alumno = Alumno::StdToAlumno($al);
        $rows .= $alumno->ToString();
        ////$returnString = $returnString.$alumno->ToString();
      }
  }
  echo Alumno::CreateHtmlTable($rows);
}

function ListarAlumno($legajo)
{
  $alumno = AlumnoDao::GetAlumnoFromJson(AppConfig::$alumnosJsonFileName, $legajo);
  echo Alumno::CreateHtmlTable($alumno->ToString());
}
