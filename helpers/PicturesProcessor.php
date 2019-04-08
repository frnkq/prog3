<?php
require_once 'AppConfig.php';
require_once 'GetDir.php';

class PicturesProcessor
{
  public static function UploadProfilePicture($foto, $nombre, $legajo)
  {
    $uploadDir = GetDir::Get(AppConfig::$profilePicturesDir);
    $backupsDir = GetDir::Get(AppConfig::$profilePicturesBackupDir);
    $nameExt = explode(".", $foto["name"]);
    $nameExt = end($nameExt);
  
    $finalPictureName = $legajo."_".$nombre.".".$nameExt;
    $picturePath = "$uploadsDir/$finalPictureName";
    
    //$watermarkedImage = self::WaterMarkImage(); 
    //self::UploadImage($watermarkedImage);
    if(!file_exists($picturePath))
   {
      $marca = imagecreatefrompng("resources/images/logo.png");
  
      $img = imagecreatefromjpeg($foto["tmp_name"]);
      //move_uploaded_file($foto["tmp_name"], $picturePath);
      $right = 10;
      $bottom = 10;
      $jx = imagesx($marca);
      $jy = imagesy($marca);
      imagecopy($img, $marca, imagesx($img) - $jx -$right, imagesy($img) - $jy - $bottom, 0, 0, imagesx($marca), imagesy($marca));
  
      move_uploaded_file($foto["tmp_name"], $picturePath);
      imagepng($img, $picturePath."withmark");
    }
    else
    {
      $backupFinalName = $legajo."_".$nombre."_".date("Y-M-D_hia").".".$nameExt;
  
      rename("$uploadsDir/$finalPictureName", "$backupsUploadsDir/$backupFinalName");
  
      move_uploaded_file($foto["tmp_name"], "$uploadsDir/$finalPictureName");
    }
    return "$picturePath";
  }
}
