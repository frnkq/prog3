<?php

class ReturnResponse
{
  public static function Response($operation, $status, $statusCode, $object)
  {
    $result = array(
      'Operation' => $operation,
      'Result' => $status,
      'Status code' => $statusCode,
      'Status message' => self::GetStatusMessage($statusCode),
      'Object' => ($object == false) ? null : $object
    );

    return json_encode($result);
  }

  public static function GetStatusMessage($codeNumber)
  {
    switch($codeNumber)
    {
      //Alumnos api messages
      case 700:
        return "Alumnos retornados";
      case 701:
        return "Alumno no encontrado";
      case 702:
        return "Alumno encontrado";
      case 703:
        return "Alumno no actualizado";
      case 704:
        return "Alumno actualizado";
      case 705:
        return "Alumno no eliminado";
      case 706:
        return "Alumno eliminado";
      case 707:
        return "Alumno no creado";
      case 708:
        return "Alumno creado";
      default:
        return "missing status message";
    }
  }
}

function ReturnResponse($success, $errorCode, $object)
{
  $result = array(
    'Result' => $success,
    'Object' => $object
  );

  if(!$success)
    $result["ErrorCode"] = $errorCode;

  return json_encode($result);
}
