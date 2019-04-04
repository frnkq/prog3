<?php
require_once 'funciones/CrearAlumno.php';
require_once 'funciones/ListarAlumnos.php';
require_once 'funciones/BorrarAlumno.php';
require_once 'funciones/ModificarAlumno.php';
require_once 'helpers/ProcessRequest.php';
require_once 'helpers/DecodifyJson.php';

$header = "<h1>Alumnos</h1><hr>";
$fileName = "alumnos.json";

$parameters = ProcessRequest();

switch($_SERVER['REQUEST_METHOD'])
{
  case 'POST':
    $postParameters = $parameters["post"];
    $alumno = CrearAlumno($postParameters["nombre"],
      $postParameters["edad"], $postParameters["dni"],
      $postParameters["legajo"], $postParameters["foto"]
    );
    break;

  case 'GET':
    echo $header;
    if(!is_null($legajo = $parameters["get"]["legajo"]))
    {
      if(!is_null($alumno = ListarAlumno($legajo)))
      {
        echo $alumno->ToString();
      }
      else
      {
        echo "Alumno no encontrado";
      }
    }
    else
    {
      echo ListarAlumnos();
    }
    break;

  case 'PUT':
      $alumnoToModify = DecodifyJson::JsonToArray(trim(file_get_contents("php://input")));
      if($alumnoToModify != null)
      {
        if(array_key_exists("legajo", $alumnoToModify))
        {
          ModificarAlumno($alumnoToModify);
        }
        else
        {
            echo "alumno no encontrado";
        }
      }
    break;

  case 'DELETE':
    $alumnoToDelete = DecodifyJson::JsonToArray(trim(file_get_contents("php://input")));
    if(array_key_exists("legajo", $alumnoToDelete))
    {
      BorrarAlumno($alumnoToDelete);
    }
    break;

  default:
    echo $header;
    echo "Method not allowed";
}
