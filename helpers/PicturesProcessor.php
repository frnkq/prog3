<?php
require_once 'AppConfig.php';
require_once 'FilesHelper.php';

class PicturesProcessor
{
  public static function UploadProfilePicture($foto, $nombre, $legajo)
  {
    $extension = FilesHelper::GetExtension($foto["name"]);
    $watermarkedImage = self::WatermarkImage($foto["tmp_name"], $extension);
    $nameParameters = array($legajo, $nombre);
    return self::LocateProfilePicture($watermarkedImage, $nameParameters);

  }

  public static function WatermarkImage($picture, $extension)
  {
    $logoPath = FilesHelper::GetDir(AppConfig::$resourcesDir)."/images/logo.png";
    $watermark = imagecreatefrompng($logoPath);

    if($extension == "jpg")
    {
      $img = imagecreatefromjpeg($picture);
    }
    else if($extension == "png")
    {
      $img = imagecreatefrompng($picture);
    }

    $right = 10;
    $bottom = 10;
    $jx = imagesx($watermark);
    $jy = imagesy($watermark);

    imagecopy($img, $watermark,
      imagesx($img) - $jx -$right,
      imagesy($img) - $jy - $bottom,
      0, 0, imagesx($watermark), imagesy($watermark)
    );
    move_uploaded_file($picture, $picture);
    return $img;
  }

  public static function LocateProfilePicture($watermarkedImage, $nameParameters)
  {
    $uploadDir = FilesHelper::GetDir(AppConfig::$profilePicturesDir);
    $backupsDir = FilesHelper::GetDir(AppConfig::$profilePicturesBackupDir);

    $finalName = FilesHelper::ConstructFileName($nameParameters, "jpg");

    if(!file_exists("$uploadDir/$finalName"))
    {
      imagepng($watermarkedImage, "$uploadDir/$finalName");
    }
    else
    {
      array_push($nameParameters, date("Y-m-d_His"));
      $backupFinalName = FilesHelper::ConstructFileName($nameParameters, "jpg");

      rename("$uploadDir/$finalName", "$backupsDir/$backupFinalName");
      imagepng($watermarkedImage, "$uploadDir/$finalName");
    }
      return "$uploadDir/$finalName";
  }
}
