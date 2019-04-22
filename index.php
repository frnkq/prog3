<?php
require_once 'funciones/CrearAlumno.php';
require_once 'funciones/ListarAlumnos.php';
require_once 'funciones/BorrarAlumno.php';
require_once 'funciones/ModificarAlumno.php';
require_once 'helpers/ProcessRequest.php';
require_once 'helpers/DecodifyJson.php';
require_once 'helpers/AppConfig.php';


$parameters = ProcessRequest();


$header = "<h1>Alumnos</h1><hr>";


switch($_SERVER['REQUEST_METHOD'])
{
  case 'GET':
    if(AppConfig::isHtmlClient()) echo $header;

    if(!is_null($legajo = $parameters["get"]["legajo"]))
      $response = ListarAlumno($legajo);
    else
      $response = ListarAlumnos();
    break;

  case 'POST':
    $postParameters = $parameters["post"];
    $response = CrearAlumno($postParameters);
    break;

  case 'PUT':
      $alumnoToModify = DecodifyJson::JsonToArray(trim(file_get_contents("php://input")));
      if($alumnoToModify != null && array_key_exists("legajo", $alumnoToModify))
        $response = ModificarAlumno($alumnoToModify);
    break;

  case 'DELETE':
    $alumnoToDelete = DecodifyJson::JsonToArray(trim(file_get_contents("php://input")));
    if($alumnoToDelete != null && array_key_exists("legajo", $alumnoToDelete))
      $response = BorrarAlumno($alumnoToDelete);
    break;

  default:
    echo $header;
    echo "Method not allowed";
    break;

}
if(isset($response) && !AppConfig::isHtmlClient())
  echo $response;
