<?php
require_once 'helpers/AppConfig.php';
require_once 'clases/Alumno.php';

class AlumnoDaoFiles
{
    public static function GetAlumnos($format)
    {
      switch($format)
      {
        case "json":
          $alumnos = array();
          if(file_exists(AppConfig::$alumnosJsonFileName))
            $alumnos = json_decode(file_get_contents(AppConfig::$alumnosJsonFileName), true);
          return $alumnos;
          break;

        case "csv":

          break;
      }
    }

    public static function GetAlumnoByLegajo($format, $legajo)
    {
      $alumnos = self::GetAlumnos($format);
      foreach($alumnos as $alumno)
      {
          $alumno = Alumno::StdToAlumno($alumno);
          if($alumno->legajo == $legajo)
          {
              return $alumno;
          }
      }
      return null;
    }


    public static function SaveAlumno($alumno, $format)
    {
      $alumnos = array();
      $alumnos = self::GetAlumnos($format);
      if(is_null(self::GetAlumnoByLegajo($format, $alumno->legajo)))
      {
        array_push($alumnos, $alumno);
      }
      else
      {
        //todo modificar
        echo "ya existe";
        return false;
      }

      return self::SaveAlumnos($alumnos, $format);
  }

  public static function SaveAlumnos($alumnos, $source)
  {
    switch($source)
    {
    case "json":
      file_put_contents(AppConfig::$alumnosJsonFileName, json_encode($alumnos));
      return true;
      break;

    case "csv":
      //file_put_contents($fileName, $alumnos);
      return true;
      break;

    }
  }
}
