<h1>Alumnos</h1>
<hr>
<?php

require_once 'funciones/CrearAlumno.php';
require_once 'funciones/ListarAlumnos.php';
require_once 'funciones/BorrarAlumno.php';
require_once 'funciones/ModificarAlumno.php';

$fileName = "alumnos.json";
$legajo = null;

if(isset($_POST['nombre']) &&
  isset($_POST['edad']) && isset($_POST['dni']) && isset($_POST['legajo']))
{
  $nombre = $_POST['nombre'];
  $edad = $_POST['edad'];
  $dni = $_POST['dni'];
  $legajo = $_POST['legajo'];
}

if(isset($_GET['legajo']))
{
  $legajo = $_GET['legajo'];
}

switch($_SERVER['REQUEST_METHOD'])
{
  case 'POST':
      CrearAlumno($nombre, $edad, $dni, $legajo);
    break;

  case 'GET':
    if(!is_null($legajo))
    {
      $alumno = ListarAlumno($legajo);

      if(!is_null($alumno))
        echo ListarAlumno($legajo)->ToString();
      else
        echo "Alumno no encontrado";
      die();
    }
    else
    {
      echo ListarAlumnos();
      die();
    }
    break;

  case 'PUT':
    if(!is_null($legajo))
    {
      ModificarAlumno($legajo, $_GET);
    }
    die();
    break;

  case 'DELETE':
    if(!is_null($legajo))
    {
     BorrarAlumno($legajo);
    }
    break;

  default:
    echo "Method not allowed";
    die();
}
die();
