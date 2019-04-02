<?php
require_once 'clases/Alumno.php';
require_once 'helpers/ReturnResponse.php';

function CrearAlumno($nombre, $edad, $dni, $legajo, $foto)
{
  $fileName = "alumnos.json";
  $alumnos = array();

  $alumno = new Alumno($nombre, $edad, $dni, $legajo);
  $alumno->foto = ProcessFoto($foto, $nombre,$legajo);


  if(file_exists($fileName))
  {
    $alumnos = (array) json_decode(file_get_contents($fileName));
  }

  foreach($alumnos as $al)
  {
    if($al->legajo === $legajo)
    {
      echo ReturnResponse(false, "Un alumno con ese legajo ya existe", null);
      die();
    }

  }

  array_push($alumnos, $alumno);
  file_put_contents($fileName, json_encode($alumnos));

  echo ReturnResponse(true, null, $alumno);
  return $alumno;
}

function ProcessFoto($foto, $nombre, $legajo)
{
  $uploadsDir = "fotos";
  $backupsUploadsDir = "fotosBackup";
  $nameExt = explode(".", $foto["name"]);
  $nameExt = end($nameExt);

  $finalPictureName = $legajo."_".$nombre.".".$nameExt;

  if(!file_exists("$uploadsDir/$finalPictureName"))
  {
    $watermark = imagecreatefrompng("resources/images/logo.png");
    move_uploaded_file($foto["tmp_name"], "$uploadsDir/$finalPictureName");
    $image = imagecreatefromjpeg("$uploadsDir/$finalPictureName");
    $margen_dcho = 10;
    $margen_inf = 10;
    $sx = imagesx($watermark);
    $sy = imagesy($watermark);
    imagecopy($image, $watermark,
      imagesx($watermark) - $sx - $margen_dcho, imagesy($watermark) - $sy - $margen_inf, 0, 0, 
      imagesx($watermark), imagesy($watermark)
    );

  }
  else
  {
    $backupFinalName = $legajo."_".$nombre."_".date("Y-M-D_hia").".".$nameExt;

    rename("$uploadsDir/$finalPictureName", "$backupsUploadsDir/$backupFinalName");

    move_uploaded_file($foto["tmp_name"], "$uploadsDir/$finalPictureName");
  }
  return "$uploadsDir/$finalPictureName";
}
