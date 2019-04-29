
<?php
//require_once 'helpers/AppConfig.php';
//require_once 'helpers/db/MyPDO.php';
//require_once 'clases/Entity.php';

class DaoMysql
{
    private static $tableName = "alumnos";
    private static $entity = "Alumno";

    /******************************GET***********************************/

    /**
     * GetAllAlumnos Returns all alumnos from $tableName
     *
     * @static
     * @access public
     * @return Array of alumnos
     */
    public static function GetAll()
    {
      $query = MyPDO::GetPDO()->ReturnQuery("select * from ".self::$tableName);
      $query->execute();
      $objects = array();
      try
      {
        $objects = $query->fetchAll(PDO::FETCH_CLASS, self::$entity);
      }
      catch(Exception $e)
      {

      }
      return $objects;
    }

    /**
     * GetAlumnoByLegajo Returns an alumno from $tableName where $legajo=$legajo
     *
     * @param string $legajo legajo to match on get query
     * @static
     * @access public
     * @return Alumno $alumno
     */
    public static function GetByIdentifier($identifier)
    {
      $query = MyPDO::GetPDO()->ReturnQuery("select * from ".self::$tableName." where id=:identifier"); //CHANGE
      $query->bindValue(":identifier", $identifier, PDO::PARAM_STR);
      $query->execute();
      $object = null;
      try
      {
        $object = $query->fetchObject($entity);
      }
      catch(Exception $e)
      {

      }
      return $object;
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
    public static function Create($object)
    {
      //CHANGE
      $fields = " (legajo, nombre, edad, dni, apellido, foto) ";
      $values = "values (:legajo, :nombre, :edad, :dni, :apellido, :foto);";

      $insertQuery = "INSERT INTO ".self::$tableName.$fields.$values;
      $query = MyPDO::GetPDO()->ReturnQuery($insertQuery);

      $query->bindValue(':legajo', $object->legajo, PDO::PARAM_STR);
      $query->bindValue(':nombre', $object->nombre, PDO::PARAM_STR);
      $query->bindValue(':edad', $object->edad, PDO::PARAM_INT);
      $query->bindValue(':dni', $object->dni, PDO::PARAM_STR);
      $query->bindValue(':apellido', $object->apellido, PDO::PARAM_STR);
      $query->bindValue(':foto', $object->foto, PDO::PARAM_STR);

      $result = null;
      try
      {
        $result = $query->execute();
      }
      catch(Exception $e)
      {

      }
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
    public static function Update($object)
    {
      //CHANGE
      $originalObject = self::GetByIdentifier($object->legajo);
      if($originalObject == false)
      {
          return false;
      }
      $updateQuery = "update ".self::$tableName." set nombre=:nombre, edad=:edad, dni=:dni, apellido=:apellido, foto=:foto ";
      $updateQuery .= "where legajo=:legajo";
      $query = MyPDO::GetPDO()->ReturnQuery($updateQuery);

      $query->bindValue(':legajo', $object->legajo, PDO::PARAM_STR);

      //preserve old data if nulls are given
      $nombre = (is_null($object->nombre)) ? $originalObject->nombre : $object->nombre;
      $edad = (is_null($object->edad)) ? $originalObject->edad : $object->edad;
      $dni = (is_null($object->dni)) ? $originalObject->dni : $object->dni;
      $apellido = (is_null($object->apellido)) ? $originalObject->apellido : $object->apellido;
      $foto = (is_null($object->foto)) ? $originalObject->foto : $object->foto;

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
    public static function DeleteByIdentifier($identifier)
    {
        if(self::GetByIdentifier($identifier) == null)
          return false;
        $deleteQuery = "delete from ".self::$tableName." where legajo=:identifier";//CHANGE
        $query = MyPDO::GetPDO()->ReturnQuery($deleteQuery);
        $query->bindValue(':identifier', $identifier, PDO::PARAM_STR);//CHANGE

        return self::Delete($query);
    }

    public static function Delete($query)
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
