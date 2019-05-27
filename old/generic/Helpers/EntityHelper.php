<?php
class EntityHelper
{
  public static function StdToEntity($object)
  {
    $nombre = null;
    $edad = null;
    $dni = null;
    $legajo = null;
    $foto = null;
    $apellido = null;
    if(is_array($object))
    {
      if(array_key_exists("nombre", $object))
        $nombre = $object["nombre"];
      if(array_key_exists("edad", $object))
        $edad = $object["edad"];
      if(array_key_exists("dni", $object))
        $dni = $object["dni"];
      if(array_key_exists("legajo", $object))
        $legajo = $object["legajo"];
      if(array_key_exists("foto", $object))
        $foto = $object["foto"];
      if(array_key_exists("apellido", $object))
        $apellido = $object["apellido"];

      $parameters = array(
        "nombre" => $nombre,
        "edad" => $edad,
        "dni" => $dni,
        "legajo" => $legajo,
        "foto" => $foto,
        "apellido" => $apellido
      );

      $convertedObject = new Alumno();
      $convertedObject->SetParams($parameters);
      return $convertedObject;
  }
}
