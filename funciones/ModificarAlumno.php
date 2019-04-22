<?php
require_once 'helpers/AppConfig.php';
require_once 'helpers/ReturnResponse.php';
require_once 'helpers/PicturesProcessor.php';

require_once 'clases/AlumnoDAO.php';
require_once 'clases/Alumno.php';

function ModificarAlumno($alumnoToModify)
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
  $alumnoToModify = Alumno::StdToAlumno($alumnoToModify);
  $alumnos = AlumnoDaoFiles::GetAlumnosFromJson(AppConfig::$alumnosJsonFileName);

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

      $alumnoParameters = array("nombre" => $nombre, "edad" => $edad, "dni" => $dni, "legajo" => $legajo);

      $newAlumno = new Alumno($alumnoParameters);

      $alumnosCopy[$key] = $newAlumno;

      $result = ReturnResponse(true, null, array("OldAlumno" => $alumno, "NewAlumno" => $newAlumno));
      $found = true;
      break;
    }

    if(!$found)
    {
      $result = ReturnResponse(false, "Alumno no encontrado", null);
    }
  }

  file_put_contents(AppConfig::$alumnosJsonFileName, json_encode($alumnosCopy));
  echo $result;
}
