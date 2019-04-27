<?php
require_once 'helpers/AppConfig.php';
require_once 'helpers/ReturnResponse.php';
require_once 'helpers/PicturesProcessor.php';

require_once 'clases/AlumnoDAO.php';
require_once 'clases/Alumno.php';

function ModificarAlumno($alumnoToModify, $source)
{
  switch($source)
  {
     case "mysql":
       return ModificarAlumnoMysql($alumnoToModify);
       break;

     case "json":
       return ModificarAlumnoJson($alumnoToModify);
       break;

     case "csv":

       break;
  }
}
function ModificarAlumnoMysql($alumnoToModify)
{
  if(!get_class($alumnoToModify) != "Alumno")
    $alumno = Alumno::StdToAlumno($alumnoToModify);
  $alumno = $alumnoToModify;
  $alumnoBefore = AlumnoDAO::GetAlumnoByLegajo($alumno->legajo);
  $success = AlumnoDao::UpdateAlumno($alumno);
  $alumnoAfter = AlumnoDAO::GetAlumnoByLegajo($alumno->legajo);

  if($success)
  {
    $response = ReturnResponse::Response(AppConfig::$apiActions['update'],
      true, 704, array("OldAlumno" => $alumnoBefore, "NewAlumno" => $alumnoAfter));
  }
  else
  {
    $response = ReturnResponse::Response(AppConfig::$apiActions['update'], 
    false, 703, $alumnoBefore);
  }
  return $response;
}

function ModificarAlumnoJson($alumnoToModify)
{
  $alumnos = AlumnoDaoFiles::GetAlumnos("json");

  $alumnosCopy = $alumnos;
  $result = null;
  $found = false;
  foreach($alumnos as $key => $alumno)
  {
    $alumno = Alumno::StdToAlumno($alumno);

    if($alumno->legajo == $alumnoToModify->legajo)
    {
      $legajo = $alumno->legajo;
      $nombre = (!is_null($alumnoToModify->nombre)) ? $alumnoToModify->nombre : $alumno->nombre;
      $edad = (!is_null($alumnoToModify->edad)) ? $alumnoToModify->edad : $alumno->edad;
      $dni = (!is_null($alumnoToModify->dni)) ? $alumnoToModify->dni : $alumno->dni;
      $apellido = (!is_null($alumnoToModify->apellido)) ? $alumnoToModify->apellido : $alumno->apellido;

      $alumnoParameters = array(
        "nombre" => $nombre,
        "apellido" => $apellido,
        "edad" => $edad, 
        "dni" => $dni, 
        "legajo" => $legajo);

      $newAlumno = new Alumno();
      $newAlumno->setParams($alumnoParameters);

      $alumnosCopy[$key] = $newAlumno;

      //$result = ReturnResponse(true, null, array("OldAlumno" => $alumno, "NewAlumno" => $newAlumno));
      $found = true;
      break;
    }

    if(!$found)
    {
      //$result = ReturnResponse(false, "Alumno no encontrado", null);
    }
  }

  AlumnoDaoFiles::SaveAlumnos($alumnosCopy, "json");
  echo $result;
}
