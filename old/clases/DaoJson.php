<?php
require_once 'helpers/AppConfig.php';

class DaoJson
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
      if(file_exists(AppConfig::$jsonFilename))
      {
        try
        {
          $objects = json_decode(file_get_contents(AppConfig::$jsonFilename), true);
        }
        catch(Exception $e)
        {

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
          $object = Alumno::StdToAlumno($object);//CHANGE STD CONVERTER
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
      if(!is_null(self::GetByIdentifier($object->legajo)))
      {
        return false;
      }
      array_push($objects, $object);
      return self::SaveAll($objects);
    }

  /**
   * SaveAll
   *
   * @param mixed $objects
   * @static
   * @access public
   * @return void
   */
  public static function SaveAll($objects)
  {
    $fileName = AppConfig::$jsonFilename;
    try
    {
      file_put_contents(AppConfig::$jsonFilename, json_encode($objects));
    }
    catch(Exception $e)
    {
      return false;
    }
    return true;
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
      $object = Alumno::StdToAlumno($object);//CHANGE
      $newObject = null;

      if($object->legajo == $object->legajo)
      {
        //CHANGE
        $legajo = $object->legajo;
        $nombre = (!is_null($objectToModify->nombre)) ? $objectToModify->nombre : $object->nombre;
        $edad = (!is_null($objectToModify->edad)) ? $objectToModify->edad : $object->edad;
        $dni = (!is_null($objectToModify->dni)) ? $objectToModify->dni : $object->dni;
        $apellido = (!is_null($objectToModify->apellido)) ? $objectToModify->apellido : $object->apellido;
        $foto = (!is_null($objectToModify->foto)) ? $objectToModify->foto : $object->foto;
        //CHANGE
        $objectParameters = array(
          "nombre" => $nombre,
          "apellido" => $apellido,
          "edad" => $edad,
          "dni" => $dni,
          "legajo" => $legajo,
          "foto" => $foto);

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

    self::SaveAll($objectsCopy);
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
      $object = Alumno::StdToAlumno($object); //CHANGE
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
      self::SaveAll($objectsCopy);
      return $deletedObject;
    }
    else
    {
      return null;
    }
  }
}
