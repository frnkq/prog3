<?php
require_once 'clases/Alumno.php';
require_once 'clases/AlumnoDAO.php';

require_once 'helpers/ReturnResponse.php';

function ListarAlumnos()
{
  $alumnos = AlumnoDAO::GetAllAlumnos();
  $rows = "";
  foreach($alumnos as $alumno)
  {
    $rows .= $alumno->ToString();
  }
  echo Alumno::CreateHtmlTable($rows);

}

//DEPRECATED due to PDO
//function ListarAlumnos()
//{
//  $returnString = "";
//  $alumnos = AlumnoDao::GetAlumnosFromJson(AppConfig::$alumnosJsonFileName);
//  $rows = "";
//  if(!is_null($alumnos))
//  {
//      foreach($alumnos as $al)
//      {
//        $alumno = Alumno::StdToAlumno($al);
//        $rows .= $alumno->ToString();
//        ////$returnString = $returnString.$alumno->ToString();
//      }
//  }
//  echo Alumno::CreateHtmlTable($rows);
//}

function ListarAlumno($legajo)
{
  $alumno = AlumnoDAO::GetAlumnoByLegajo($legajo);
  if($alumno)
  {
    echo Alumno::CreateHtmlTable($alumno->ToString());
  }
  else
  {
    echo "Alumno no encontrado";
  }
}
