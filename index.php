<?php

require_once 'funciones/CrearAlumno.php';
require_once 'funciones/ListarAlumnos.php';
require_once 'funciones/BorrarAlumno.php';
require_once 'funciones/ModificarAlumno.php';
require_once 'helpers/ProcessRequest.php';

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
    if(!is_null($legajo))
    {
      ModificarAlumno($legajo, $parameters["get"]);
    }
    break;

  case 'DELETE':
    if(!is_null($legajo))
    {
     BorrarAlumno($legajo);
    }
    break;

  default:
    echo $header;
    echo "Method not allowed";
}
