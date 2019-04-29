<?php
require_once 'helpers/AppConfig.php';
require_once 'clases/Alumno.php';
require_once 'helpers/db/MyPDO.php';

class AlumnoDao
{

    private static $tableName = "alumnos";

    /******************************GET***********************************/


    /**
     * GetAllAlumnos Returns all alumnos from $tableName
     *
     * @static
     * @access public
     * @return Array of alumnos
     */
    public static function GetAllAlumnos()
    {
      $query = MyPDO::GetPDO()->ReturnQuery("select * from ".self::$tableName);
      $query->execute();
      $alumnos = array();
      $alumnos = $query->fetchAll(PDO::FETCH_CLASS, "Alumno");
      return $alumnos;
    }

    /**
     * GetAlumnoByLegajo Returns an alumno from $tableName where $legajo=$legajo
     *
     * @param string $legajo legajo to match on get query
     * @static
     * @access public
     * @return Alumno $alumno
     */
    public static function GetAlumnoByLegajo($legajo)
    {
      $query = MyPDO::GetPDO()->ReturnQuery("select * from ".self::$tableName." where legajo=:legajo");
      $query->bindValue(":legajo", $legajo, PDO::PARAM_STR);
      $query->execute();
      $alumno = $query->fetchObject("Alumno");
      return $alumno;
    }

    /**
     * GetAlumnoById Returns an alumno from $tbaleName where id=$id
     *
     * @param int $id id to match on get query
     * @static
     * @access public
     * @return Alumno $alumno
     */
    public static function GetAlumnoById($id)
    {
      $query = MyPDO::GetPDO()->ReturnQuery("select * from ".self::$tableName." where id=:id");
      $query->bindValue(":id", $id, PDO::PARAM_INT);
      $query->execute();
      $alumno = $query->fetchObject("Alumno");
      return $alumno;
    }

    /******************************CREATE***********************************/


    /**
     * SaveAlumno
     *  Saves an alumno into $tableName
     * @param Alumno $alumno
     * @static
     * @access public
     * @return void
     */
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
      return $result;
    }


    /******************************UPDATE***********************************/

    /**
     * UpdateAlumno Updates alumno from self::$tableName
     *
     * @param mixed $alumno Alumno to be edited, legajo has to be existent
     * @static
     * @access public
     * @return void
     */
    public static function UpdateAlumno($alumno)
    {
      $originalAlumno = self::GetAlumnoByLegajo($alumno->legajo);
      if($originalAlumno == false)
      {
          return false;
      }
      $updateQuery = "update ".self::$tableName." set nombre=:nombre, edad=:edad, dni=:dni, apellido=:apellido, foto=:foto ";
      $updateQuery .= "where legajo=:legajo";
      $query = MyPDO::GetPDO()->ReturnQuery($updateQuery);

      $query->bindValue(':legajo', $alumno->legajo, PDO::PARAM_STR);

      //preserve old data if nulls are given
      $nombre = (is_null($alumno->nombre)) ? $originalAlumno->nombre : $alumno->nombre;
      $edad = (is_null($alumno->edad)) ? $originalAlumno->edad : $alumno->edad;
      $dni = (is_null($alumno->dni)) ? $originalAlumno->dni : $alumno->dni;
      $apellido = (is_null($alumno->apellido)) ? $originalAlumno->apellido : $alumno->apellido;
      $foto = (is_null($alumno->foto)) ? $originalAlumno->foto : $alumno->foto;

      $query->bindValue(':nombre', $nombre, PDO::PARAM_STR);
      $query->bindValue(':edad', $edad, PDO::PARAM_INT);
      $query->bindValue(':dni', $dni, PDO::PARAM_STR);
      $query->bindValue(':apellido', $apellido, PDO::PARAM_STR);
      $query->bindValue(':foto', $foto, PDO::PARAM_STR);

      try
      {
        $result = $query->execute();
        return true;
      }
      catch(Exception $e)
      {
        return false;
      }
    }

    /******************************DELETE***********************************/


    /**
     * BorrarAlumnoByLegajo
     *   Deletes an alumno from self::$tableName where legajo=$legajo
     * @param string $legajo legajo to match on delete query
     * @static
     * @access public
     * @return void
     */
    public static function DeleteAlumnoByLegajo($legajo)
    {
        if(self::GetAlumnoByLegajo($legajo) == null)
          return false;
        $deleteQuery = "delete from ".self::$tableName." where legajo=:legajo";
        $query = MyPDO::GetPDO()->ReturnQuery($deleteQuery);
        $query->bindValue(':legajo', $legajo, PDO::PARAM_STR);

        return self::DeleteAlumno($query);
    }

    /**
     * DeleteAlumnoById
     *  Deletes an alumno from self::$tableName where id=$id
     * @param int $id id to match on delete query
     * @static
     * @access public
     * @return void
     */
    public static function DeleteAlumnoById($id)
    {
        $deleteQuery = "delete from ".self::$tableName." where id=:id";
        $query = MyPDO::GetPDO()->ReturnQuery($deleteQuery);
        $query->bindValue(':id', $id, PDO::PARAM_INT);

        return self::DeleteAlumno($query);
    }

    /**
     * DeleteAlumno
     *  Performs a deletion on self::$tableName matching query
     * @param mixed $query PDO query to perform a deletion command
     * @static
     * @access public
     * @return boolean true=deletion successfull false=deletion unsuccessfull
     */
    public static function DeleteAlumno($query)
    {
        try
        {
          $result = $query->execute();
          return true;
        }
        catch(Exception $e)
        {
          return false;
        }
    }


}
