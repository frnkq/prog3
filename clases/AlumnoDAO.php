<?php
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
        $alumnos = GetAlumnosFromJson($fileName);
        
        foreach($alumnos as $alumno)
        {
            if($alumno->legajo == $legajo)
            {
                return $alumno;
            }
        }
        return null;
    }
}