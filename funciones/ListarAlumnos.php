<?php
require_once 'clases/Alumno.php';
require_once 'clases/AlumnoDAO.php';
require_once 'clases/AlumnoDAOfiles.php';

require_once 'helpers/ReturnResponse.php';
require_once 'helpers/AppConfig.php';

/**
 * ListarAlumnos
 *
 * @access public
 * @return void
 */
function ListarAlumnos($source)
{
  $alumnos = array();

  switch($source)
  {
    case "mysql":
      return ListarAlumnosMysql();
      break;

    case "json":
      return ListarAlumnosJson();
      break;

    case "csv":

      break;
  }
}

/**
 * ListarAlumno
 *
 * @param mixed $legajo
 * @access public
 * @return void
 */
function ListarAlumno($legajo, $source)
{
  switch($source)
  {
    case "mysql":
      return ListarAlumnoMysql($legajo);
      break;

    case "json":
      return ListarAlumnoJson($legajo);
      break;

    case "csv":

      break;
  }
}


/**
 * ListarAlumnosMysql 
 * 
 * @access public
 * @return void
 */
function ListarAlumnosMysql()
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

/**
 * ListarAlumnoMysql 
 * 
 * @param mixed $legajo 
 * @access public
 * @return void
 */
function ListarAlumnoMysql($legajo)
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
/**
 * ListarAlumnosJson
 *
 * @access public
 * @return void
 */
function ListarAlumnosJson()
{
   $returnString = "";
   $alumnos = AlumnoDaoFiles::GetAlumnos("json");
   $rows = "";
   if(!is_null($alumnos))
   {
       foreach($alumnos as $al)
       {
         $alumno = Alumno::StdToAlumno($al);
         $rows .= $alumno->ToString();
       }
   }
   if(AppConfig::isHtmlClient()) echo Alumno::CreateHtmlTable($rows);
   return ReturnResponse::Response(AppConfig::$apiActions['get'], true, 700, $alumnos);
}

/**
 * ListarAlumnoJson
 *
 * @param mixed $legajo
 * @access public
 * @return void
 */
function ListarAlumnoJson($legajo)
{
  $alumno = AlumnoDaoFiles::GetAlumnoByLegajo("json", $legajo);

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

/**
 * ListarAlumnosCsv 
 * 
 * @access public
 * @return void
 */
function ListarAlumnosCsv()
{

}

/**
 * ListarAlumnoCsv 
 * 
 * @param mixed $legajo 
 * @access public
 * @return void
 */
function ListarAlumnoCsv($legajo)
{

}
