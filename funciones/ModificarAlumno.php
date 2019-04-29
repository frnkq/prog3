<?php
require_once 'helpers/AppConfig.php';
require_once 'helpers/ReturnResponse.php';
require_once 'helpers/PicturesProcessor.php';

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
       return ModificarAlumnoCsv($alumnoToModify);
       break;
  }
}

function ModificarAlumnoMysql($alumnoToModify)
{
  if(!get_class($alumnoToModify) != "Alumno")
    $alumno = Alumno::StdToAlumno($alumnoToModify);
  $alumno = $alumnoToModify;
  $alumnoBefore = DaoMysql::GetByIdentifier($alumno->legajo);
  $success = DaoMysql::Update($alumno);
  $alumnoAfter = DaoMysql::GetByIdentifier($alumno->legajo);

  if($success)
  {
    $response = ReturnResponse::Response("update",true, 704, array("OldAlumno" => $alumnoBefore, "NewAlumno" => $alumnoAfter));
  }
  else
  {
    $response = ReturnResponse::Response("update", false, 703, $alumnoBefore);
  }
  return $response;
}

function ModificarAlumnoJson($alumnoToModify)
{
  $newAlumno = DaoJson::Update($alumnoToModify);

  if(is_null($newAlumno))
  {
    $response = ReturnResponse::Response("update",false, 703, $alumnoToModify);
  }

  $response = ReturnResponse::Response("update",true, 704, $newAlumno);

  echo $response;
}

function ModificarAlumnoCsv($alumnoToModify)
{
  $newAlumno = DaoCsv::Update($alumnoToModify);

  if(is_null($newAlumno))
  {
    $response = ReturnResponse::Response("update",false, 703, $alumnoToModify);
  }

  $response = ReturnResponse::Response("update",true, 704, $newAlumno);

  echo $response;
}
