<?php
//require_once 'helpers/AppConfig.php';

class DaoJson
{

    /******************************GET***********************************/
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

    public static function GetByIdentifier($identifier)
    {
      $objects = self::GetAll();
      foreach($objects as $object)
      {
          $object = EntityHelper::StdToEntity($object);//CHANGE STD CONVERTER
          if($object->identifier == $identifier) //CHANGE IDENTIFIER
          {
              return $object;
          }
      }
      return null;
    }
    /******************************CREATE***********************************/
    public static function Create($object)
    {
      $objects = array();
      if(!is_null(self::GetAll))
        $objects = self::GetAll();
      if(!is_null(self::GetByIdentifier($object->identifier))) //CHANGE
      {
        return false;
      }

      array_push($objects, $object);
      return self::SaveAll($objects);
    }

  public static function SaveAll($objects)
  {
    $fileName = AppConfig::$jsonFilename;
    try
    {
      file_put_contents(AppConfig::$jsonFilename, json_encode($objects));
      return true;
    }
    catch(Exception $e)
    {
      return false;
    }
  }

    /******************************UPDATE***********************************/
  function Update($objectToModify)
  {
    $objects = self::GetAll();
    $objectsCopy = $objects;
    $response = null;
    $edited = false;
    foreach($objects as $key => $object)
    {
      $object = EntityHelper::StdToEntity($object);//CHANGE
      $newObject = null;

      //CHANGE
      if($object->identifier == $object->identifier)
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

    self::SaveAll($objectsCopy);
    return $newObject;
  }

  /******************************DELETE***********************************/
  function Delete($objectToDelete)
  {
    $objects = self::GetAll();
    $objectsCope = $objects;
    $deleted = false;
    foreach($objects as $key => $object)
    {
      $object = EntityHelper::StdToEntity($object); //CHANGE
      if($object->identifier === $objectToDelete->identifier) //CHANGE
      {
        unset($objectsCopy[$key]);
        $deleted = true;
        break;
      }
    }
    if($deleted)
    {
      self::SaveAll($objectsCopy);
      return $objectsCopy;
    }
    else
    {
      return null;
    }
  }
}
