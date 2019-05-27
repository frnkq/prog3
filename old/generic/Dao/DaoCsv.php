
<?php
require_once 'helpers/AppConfig.php';

class DaoCsv
{

    /******************************GET***********************************/

    /**
     * GetAll
     *
     * @static
     * @access public
     * @return void
     */
    public static function GetAll()
    {
      $objects = array();
      if(file_exists(AppConfig::$csvFilename))
      {
        try
        {
          $handle = fopen(AppConfig::$csvFilename, "r");
        }
        catch(Exception $e)
        {
          return null;
        }

        $count = 0;

        while(($data = fgetcsv($handle, 1000, AppConfig::$csvSeparator)) != FALSE)
        {
          $count++;
          if($count == 1)
            continue;
          //CHANGE esto devuelve entidad no necesita StdToEntity();
          $object = Alumno::CsvToAlumno($data);
          array_push($objects, $object);
        }
      }
      return $objects;
    }

    /**
     * GetByIdentifier
     *
     * @param mixed $identifier
     * @static
     * @access public
     * @return void
     */
    public static function GetByIdentifier($identifier)
    {
      $objects = array();
      if(!is_null(self::GetAll()))
        $objects = self::GetAll();
      foreach($objects as $object)
      {
          if($object->legajo == $identifier) //CHANGE IDENTIFIER
          {
              return $object;
          }
      }
      return null;
    }
    /******************************CREATE***********************************/

    /**
     * Create
     *
     * @param mixed $object
     * @static
     * @access public
     * @return void
     */
    public static function Create($object)
    {
      $objects = array();
      if(!is_null(self::GetAll()))
        $objects = self::GetAll();
      if(!is_null(self::GetByIdentifier($object->legajo)))//CHANGE IDENTIFIER
      {
        return false;
      }
      array_push($objects, $object);
      return self::SaveAll($objects, AppConfig::$csvAlumnoHeader); //CHANGE ALUMNO HEADER
    }

  /**
   * SaveAll
   *
   * @param mixed $objects
   * @static
   * @access public
   * @return void
   */
  public static function SaveAll($objects, $header)
  {
    $fileName = AppConfig::$csvFilename;
    $fileContent = "";
    $fileContent .= $header;
    foreach($objects as $object)
    {
      $str = Alumno::ToCsv($object); //CHANGE
      $fileContent .= $str; //CHANGE
      $fileContent .= "\n";
    }
    try
    {
      file_put_contents(AppConfig::$csvFilename, $fileContent);
      return true;
    }
    catch(Exception $e)
    {
      return false;
    }
  }

    /******************************UPDATE***********************************/

  /**
   * Update
   *
   * @param mixed $objectToModify
   * @access public
   * @return void
   */
  function Update($objectToModify)
  {
    $objects = self::GetAll();
    $objectsCopy = $objects;
    $response = null;
    $edited = false;
    foreach($objects as $key => $object)
    {
      $newObject = null;

      if($object->legajo == $object->legajo)//CHANGE IDENTIFIER
      {
        //CHANGE
        $legajo = $object->legajo;
        $nombre = (!is_null($objectToModify->nombre)) ? $objectToModify->nombre : $object->nombre;
        $edad = (!is_null($objectToModify->edad)) ? $objectToModify->edad : $object->edad;
        $dni = (!is_null($objectToModify->dni)) ? $objectToModify->dni : $object->dni;
        $apellido = (!is_null($objectToModify->apellido)) ? $objectToModify->apellido : $object->apellido;

        //CHANGE
        $objectParameters = array(
          "nombre" => $nombre,
          "apellido" => $apellido,
          "edad" => $edad,
          "dni" => $dni,
          "legajo" => $legajo);

        $newObject = new Alumno(); //CHANGE
        $newObject->setParams($objectParameters);

        $objectsCopy[$key] = $newObject;
        if(!is_null($newObject))
        {
          $edited = true;
          break;
        }
      }
    }

    if(!$edited)
    {
      return null;
    }
    //CHANGE HEADER PERHAPS ON PARAMETER
    self::SaveAll($objectsCopy, AppConfig::$csvAlumnoHeader);
    return $newObject;
  }

  /******************************DELETE***********************************/

  /**
   * Delete
   *
   * @param mixed $objectToDelete
   * @access public
   * @return void
   */
  function Delete($objectToDelete)
  {
    $objects = array();
    if(!is_null(self::GetAll()))
      $objects = self::GetAll();

    $objectsCopy = $objects;
    $deleted = false;
    $deletedObject = null;
    foreach($objects as $key => $object)
    {
      if($object->legajo === $objectToDelete->legajo) //CHANGE
      {
        $deletedObject = $objectsCopy[$key];
        unset($objectsCopy[$key]);
        $deleted = true;
        break;
      }
    }
    if($deleted)
    {
      //CHANGE HEADER PERHAPS ON PARAMETER
      self::SaveAll($objectsCopy, AppConfig::$csvAlumnoHeader);
      return $deletedObject;
    }
    else
    {
      return null;
    }
  }
}
