<?php
require_once 'funciones/CrearAlumno.php';
require_once 'funciones/ListarAlumnos.php';
require_once 'funciones/BorrarAlumno.php';
require_once 'funciones/ModificarAlumno.php';
require_once 'helpers/ProcessRequest.php';
require_once 'helpers/DecodifyJson.php';
require_once 'helpers/AppConfig.php';
require_once 'helpers/FilesHelper.php';
require_once 'helpers/ViewHelper.php';

$parameters = ProcessRequest();


$header = "<h1>Alumnos</h1><hr>";
$source = "csv";

switch($_SERVER['REQUEST_METHOD'])
{

  case 'GET':
    if(AppConfig::isHtmlClient()) echo $header;

    if(!is_null($legajo = $parameters["get"]["legajo"]))
      $response = ListarAlumno($legajo, $source);
    else
      $response = ListarAlumnos($source);
    break;

  case 'POST':
    $postParameters = $parameters["post"];
    $response = CrearAlumno($postParameters, $source);
    break;

  case 'PUT':
      $alumnoToModify = DecodifyJson::JsonToArray(trim(file_get_contents("php://input")));
      if($alumnoToModify != null && array_key_exists("legajo", $alumnoToModify))
        $response = ModificarAlumno($alumnoToModify, $source);
    break;

  case 'DELETE':
    $alumnoToDelete = DecodifyJson::JsonToArray(trim(file_get_contents("php://input")));
    if($alumnoToDelete != null && array_key_exists("legajo", $alumnoToDelete))
      $response = BorrarAlumno($alumnoToDelete, $source);
    break;

  default:
    echo $header;
    echo "Method not allowed";
    break;

}
if(isset($response) && !AppConfig::isHtmlClient())
  echo $response;
