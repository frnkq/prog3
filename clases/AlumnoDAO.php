<?php
require_once 'helpers/AppConfig.php';
require_once 'clases/Alumno.php';
require_once 'helpers/db/MyPDO.php';

class AlumnoDao
{

    private static $tableName = "alumnos";
    public static function GetAllAlumnos()
    {
      $query = MyPDO::GetPDO()->ReturnQuery("select * from ".self::$tableName);
      $query->execute();
      $alumnos = $query->fetchAll(PDO::FETCH_CLASS, "Alumno");
      return $alumnos;
    }

    public static function GetAlumnoByLegajo($legajo)
    {
      $query = MyPDO::GetPDO()->ReturnQuery("select * from ".self::$tableName." where legajo=:legajo");
      $query->bindValue(":legajo", $legajo, PDO::PARAM_STR);
      $query->execute();
      $alumno = $query->fetchObject("Alumno");
      return $alumno;
    }

    public static function GetAlumnoById($id)
    {
      $query = MyPDO::GetPDO()->ReturnQuery("select * from ".self::$tableName." where id=:id");
      $query->bindValue(":id", $id, PDO::PARAM_INT);
      $query->execute();
      $alumno = $query->fetchObject("Alumno");
      return $alumno;
    }

    public static function SaveAlumno($alumno)
    {
      $insertQuery = "INSERT INTO ".self::$tableName." (legajo, nombre, edad, dni, apellido, foto) ";
      $insertQuery .= "values (:legajo, :nombre, :edad, :dni, :apellido, :foto);";
      $query = MyPDO::GetPDO()->ReturnQuery($insertQuery);

      $query->bindValue(':legajo', $alumno->legajo, PDO::PARAM_STR);
      $query->bindValue(':nombre', $alumno->nombre, PDO::PARAM_STR);
      $query->bindValue(':edad', $alumno->edad, PDO::PARAM_INT);
      $query->bindValue(':dni', $alumno->dni, PDO::PARAM_STR);
      $query->bindValue(':apellido', $alumno->apellido, PDO::PARAM_STR);
      $query->bindValue(':foto', $alumno->foto, PDO::PARAM_STR);

      $result = $query->execute();
    }

    public static function BorrarAlumnoByLegajo($legajo)
    {
      $deleteQuery = "delete from ".self::$tableName." where legajo=:legajo";
      $query = MyPDO::GetPDO()->ReturnQuery($deleteQuery);
      $query->bindValue(":legajo", $legajo, PDO::PARAM_STR);
      $result = $query->execute();
    }

    public static function GetAlumnosFromJson($fileName)
    {
        $alumnos = array();
        if(file_exists($fileName))
        {
          $alumnos = json_decode(file_get_contents($fileName), true);
        }
        return $alumnos;
    }

    public static function UpdateAlumno($alumno)
    {
      $updateQuery = "update ".self::$tableName." set nombre=:nombre, edad=:edad, dni=:dni, apellido=:apellido ";
      $updateQuery .= "where legajo=:legajo";
      $query = MyPDO::GetPDO()->ReturnQuery($updateQuery);

      $query->bindValue(':legajo', $alumno->legajo, PDO::PARAM_STR);

      $query->bindValue(':nombre', $alumno->nombre, PDO::PARAM_STR);
      $query->bindValue(':edad', $alumno->edad, PDO::PARAM_INT);
      $query->bindValue(':dni', $alumno->dni, PDO::PARAM_STR);
      $query->bindValue(':apellido', $alumno->apellido, PDO::PARAM_STR);

      $result = $query->execute();
      var_dump($result);
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

    //Deprecated because of PDO
    //public static function SaveAlumno($alumno, $fileName)
    //{
    //  if(is_null($alumnos = self::GetAlumnosFromJson(AppConfig::$alumnosJsonFileName)))
    //  {
    //    $alumnos = array();
    //  }

    //  if(is_null(self::GetAlumnoFromJson($fileName, $alumno->legajo)))
    //  {
    //    array_push($alumnos, $alumno);
    //  }
    //  else
    //  {
    //    echo "ya existe";
    //    return false;
    //  }

    //  return self::SaveAlumnos($fileName, $alumnos);
    //}

    public static function SaveAlumnos($fileName, $alumnos)
    {
      file_put_contents($fileName, json_encode($alumnos));
      return true;
    }
}
