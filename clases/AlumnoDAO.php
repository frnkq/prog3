<?php
require_once 'helpers/AppConfig.php';
require_once 'clases/Alumno.php';

class AlumnoDao
{
    public static function GetAlumnosFromJson($fileName)
    {
        $alumnos = array();
        if(file_exists($fileName))
        {
          $alumnos = json_decode(file_get_contents($fileName), true);
        }
        return $alumnos;
    }

    public static function GetAlumnoFromJson($fileName, $legajo)
    {
        $alumnos = self::GetAlumnosFromJson($fileName);

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

    public static function SaveAlumno($alumno, $fileName)
    {
      if(is_null($alumnos = self::GetAlumnosFromJson(AppConfig::$alumnosJsonFileName)))
      {
        $alumnos = array();
      }

      if(is_null(self::GetAlumnoFromJson($fileName, $alumno->legajo)))
      {
        array_push($alumnos, $alumno);
      }
      else
      {
        echo "ya existe";
        return false;
      }

      return self::SaveAlumnos($fileName, $alumnos);
    }

    public static function SaveAlumnos($fileName, $alumnos)
    {
      file_put_contents($fileName, json_encode($alumnos));
      return true;
    }
}
