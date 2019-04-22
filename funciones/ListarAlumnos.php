<?php
require_once 'clases/Alumno.php';
require_once 'clases/AlumnoDAO.php';

require_once 'helpers/ReturnResponse.php';
require_once 'helpers/AppConfig.php';

function ListarAlumnos()
{
  $alumnos = AlumnoDAO::GetAllAlumnos();
  $rows = "";
  foreach($alumnos as $alumno)
  {
    $rows .= $alumno->ToString();
  }
  if(AppConfig::isHtmlClient()) echo Alumno::CreateHtmlTable($rows);
  return ReturnResponse::Response(AppConfig::$apiActions['get'], true, 700, $alumnos);
}


function ListarAlumno($legajo)
{
  $alumno = AlumnoDAO::GetAlumnoByLegajo($legajo);

  if($alumno)
  {
    if(AppConfig::isHtmlClient()) echo Alumno::CreateHtmlTable($alumno->ToString());
    $response = ReturnResponse::Response(AppConfig::$apiActions['get'], true, 702, $alumno);
  }
  else
  {
    $response = ReturnResponse::Response(AppConfig::$apiActions['get'], false, 701, $alumno);
  }
  return $response;
}

function ListarAlumnosJson()
{
  $returnString = "";
  $alumnos = AlumnoDaoFiles::GetAlumnosFromJson(AppConfig::$alumnosJsonFileName);
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
