<?php
require_once 'helpers/AppConfig.php';
require_once 'helpers/ReturnResponse.php';
require_once 'helpers/PicturesProcessor.php';

require_once 'clases/AlumnoDAO.php';
require_once 'clases/Alumno.php';

function ModificarAlumno($alumnoToModify)
{
  $alumno = Alumno::StdToAlumno($alumnoToModify);
  var_dump($alumno);
  AlumnoDao::UpdateAlumno($alumno);
}

//function ModificarAlumno($alumnoToModify)
//{
//  $alumnoToModify = Alumno::StdToAlumno($alumnoToModify);
//  $alumnos = AlumnoDao::GetAlumnosFromJson(AppConfig::$alumnosJsonFileName);
//
//  $alumnosCopy = $alumnos;
//  $result = null;
//  $found = false;
//  foreach($alumnos as $key => $alumno)
//  {
//    $alumno = Alumno::StdToAlumno($alumno);
//
//    if($alumno->legajo == $alumnoToModify->legajo)
//    {
//      $legajo = $alumno->legajo;
//      $nombre = (!is_null($alumnoToModify->nombre)) ? $alumnoToModify->nombre : $alumno->nombre;
//      $edad = (!is_null($alumnoToModify->edad)) ? $alumnoToModify->edad : $alumno->edad;
//      $dni = (!is_null($alumnoToModify->dni)) ? $alumnoToModify->dni : $alumno->dni;
//
//      $alumnoParameters = array("nombre" => $nombre, "edad" => $edad, "dni" => $dni, "legajo" => $legajo);
//
//      $newAlumno = new Alumno($alumnoParameters);
//
//      $alumnosCopy[$key] = $newAlumno;
//
//      $result = ReturnResponse(true, null, array("OldAlumno" => $alumno, "NewAlumno" => $newAlumno));
//      $found = true;
//      break;
//    }
//
//    if(!$found)
//    {
//      $result = ReturnResponse(false, "Alumno no encontrado", null);
//    }
//  }
//
//  file_put_contents(AppConfig::$alumnosJsonFileName, json_encode($alumnosCopy));
//  echo $result;
//}
