<?php
require_once 'clases/Alumno.php';
require_once 'clases/DaoMysql.php';
require_once 'clases/DaoJson.php';
require_once 'clases/DaoCsv.php';

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
      return ListarAlumnosCsv();
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
      return ListarAlumnoCsv($legajo);
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
  $alumnos = DaoMysql::GetAll();
  $rows = "";
  foreach($alumnos as $alumno)
  {
    $rows .= $alumno->ToString();
  }
  if(AppConfig::isHtmlClient()) echo Alumno::CreateHtmlTable($rows);
  return ReturnResponse::Response("get", true, 700, $alumnos);
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
  $alumno = DaoMysql::GetByIdentifier($legajo);

  if($alumno)
  {
    if(AppConfig::isHtmlClient()) echo Alumno::CreateHtmlTable($alumno->ToString());
    $response = ReturnResponse::Response("get", true, 702, $alumno);
  }
  else
  {
    $response = ReturnResponse::Response("get", false, 701, $alumno);
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
   $alumnos = DaoJson::GetAll();
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
   return ReturnResponse::Response("get", true, 700, $alumnos);
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
  $alumno = DaoJson::GetByIdentifier($legajo);

  if($alumno)
  {
    if(AppConfig::isHtmlClient()) echo Alumno::CreateHtmlTable($alumno->ToString());
    $response = ReturnResponse::Response("get", true, 702, $alumno);
  }
  else
  {
    $response = ReturnResponse::Response("get", false, 701, $alumno);
  }
  return $response;
}

function ListarAlumnosCsv()
{
   $alumnos = DaoCsv::GetAll();
   $rows = "";
   if(!is_null($alumnos))
   {
       foreach($alumnos as $alumno)
       {
         $rows .= $alumno->ToString();
       }
   }
   if(AppConfig::isHtmlClient()) echo Alumno::CreateHtmlTable($rows);
   return ReturnResponse::Response("get", true, 700, $alumnos);
}

function ListarAlumnoCsv($legajo)
{
  $alumno = DaoCsv::GetByIdentifier($legajo);

  if($alumno)
  {
    if(AppConfig::isHtmlClient()) echo Alumno::CreateHtmlTable($alumno->ToString());
    $response = ReturnResponse::Response("get", true, 702, $alumno);
  }
  else
  {
    $response = ReturnResponse::Response("get", false, 701, $alumno);
  }
  return $response;
}
