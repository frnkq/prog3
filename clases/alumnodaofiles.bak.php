<?php
require_once 'helpers/AppConfig.php';
require_once 'clases/Alumno.php';

/**
 * AlumnoDaoFiles 
 * 
 * @package 
 * @version $id$
 * @copyright 1997-2005 The PHP Group
 * @author Tobias Schlitt <toby@php.net> 
 * @license PHP Version 3.0 {@link http://www.php.net/license/3_0.txt}
 */
class AlumnoDaoFiles
{

    /******************************GET***********************************/
    public static function GetAlumnos($format)
    {
      switch($format)
      {
        case "json":
          $alumnos = array();
          if(file_exists(AppConfig::$alumnosJsonFileName))
            $alumnos = json_decode(file_get_contents(AppConfig::$alumnosJsonFileName), true);
          return $alumnos;
          break;

        case "csv":

          break;
      }
    }

    /**
     * GetAlumnoByLegajo 
     * 
     * @param mixed $format 
     * @param mixed $legajo 
     * @static
     * @access public
     * @return void
     */
    public static function GetAlumnoByLegajo($format, $legajo)
    {
      $alumnos = self::GetAlumnos($format);
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

    /******************************CREATE***********************************/

    /**
     * SaveAlumno 
     * 
     * @param mixed $alumno 
     * @param mixed $format 
     * @static
     * @access public
     * @return void
     */
    public static function SaveAlumno($alumno, $format)
    {
      $alumnos = array();
      $alumnos = self::GetAlumnos($format);
      if(!is_null(self::GetAlumnoByLegajo($format, $alumno->legajo)))
      {
        return false;
      }

      array_push($alumnos, $alumno);
      return self::SaveAlumnos($alumnos, $format);
    }

  /**
   * SaveAlumnos 
   * 
   * @param mixed $alumnos 
   * @param mixed $source 
   * @static
   * @access public
   * @return void
   */
  public static function SaveAlumnos($alumnos, $format)
  {
    $fileName = "alumnos.broke";
    switch($format)
    {
    case "json":
      $fileName = AppConfig::$alumnosJsonFileName;
      file_put_contents(AppConfig::$alumnosJsonFileName, json_encode($alumnos));
      return true;
      break;

    case "csv":
      //file_put_contents($fileName, $alumnos);
      $fileName = AppConfig::$alumnosJsonFileName;
      return true;
      break;

    default:
      return false;
      break;
    }
    //file_put_contents($fileName, $alumnos);
  }

    /******************************UPDATE***********************************/
  function UpdateAlumno($alumnoToModify, $format)
  {
    $alumnos = AlumnoDaoFiles::GetAlumnos($format);
    $alumnosCopy = $alumnos;
    $response = null;
    $edited = false;
    foreach($alumnos as $key => $alumno)
    {
      $alumno = Alumno::StdToAlumno($alumno);
      $newAlumno = null;

      if($alumno->legajo == $alumnoToModify->legajo)
      {
        $legajo = $alumno->legajo;
        $nombre = (!is_null($alumnoToModify->nombre)) ? $alumnoToModify->nombre : $alumno->nombre;
        $edad = (!is_null($alumnoToModify->edad)) ? $alumnoToModify->edad : $alumno->edad;
        $dni = (!is_null($alumnoToModify->dni)) ? $alumnoToModify->dni : $alumno->dni;
        $apellido = (!is_null($alumnoToModify->apellido)) ? $alumnoToModify->apellido : $alumno->apellido;

        $alumnoParameters = array(
          "nombre" => $nombre,
          "apellido" => $apellido,
          "edad" => $edad, 
          "dni" => $dni, 
          "legajo" => $legajo);

        $newAlumno = new Alumno();
        $newAlumno->setParams($alumnoParameters);

        $alumnosCopy[$key] = $newAlumno;
        if(!is_null($newAlumno))
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

    self::SaveAlumnos($alumnosCopy, $format);
    return $newAlumno;
  }

  /******************************DELETE***********************************/
  function DeleteAlumno($alumnoToDelete)
  {
    $alumnos = self::GetAlumnos("json");
    $alumnosCopy = $alumnos;
    $deleted = false;
    foreach($alumnos as $key => $alumno)
    {
      $alumno = Alumno::StdToAlumno($alumno);
      if($alumno->legajo === $alumnoToDelete->legajo)
      {
        unset($alumnosCopy[$key]);
        $deleted = true;
        break;
      }
    }

    if($deleted)
    {
      self::SaveAlumnos($alumnosCopy, "json");
      return $alumnosCopy;
    }
    else
    {
      return null;
    }
  }
}
