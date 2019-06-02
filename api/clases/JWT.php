<?php

use Firebase\JWT\JWT;

class JWTAuth
{
  private static $key = "0mG_so^S3cR3t";
  private static $encryption = 'HS256';
  private static $aud = null;


  public function CreateToken($username)
  {
    $datos = array("username"=>$username);
    $payload = array(
      'iat' => time(),
      'exp' => time() + (60),
      'aud' => self::Aud(),
      'data' => $datos,
      'app' => "Franco Canevali"

    );
    return JWT::encode($payload, self::$key);
  }
  
  /**
   * VerifyToken 
   * 
   * @param mixed $token 
   * @access public
   * @return void
   */
  public function VerifyToken($token)
  {
    //empty token
    if(empty($token) || is_null($token))
      throw new Exception("invalid token");

    $decoded = null;

    //try decode it
    try
    {
      $decoded = JWT::decode($token, self::$key, 'HS256');
    }
    catch(Exception $e)
    {
      throw $e;
    }

    //compare audits
    if($decoded->aud !== self::Aud())
      throw new Exception("mismatched audits");

    return true;
  }

  public function Aud()
  {
    $aud = '';
    if(!empty($_SERVER['HTTP_CLIENT_IP']))
    {
     $aud = $_SERVER['HTTP_CLIENT_IP']; 
    }
    else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    {
      $aud = $_SERVER['HTTP_X_FORWARDED_FOR']; 
    }
    else
    {
      $aud = $_SERVER['REMOTE_ADDR'];
    }

    $aud .= @$_SERVER['HTTP_USER_AGENT'];
    $aud .= gethostname();

    return sha1($aud);
  }

  public function GetPayload($token)
  {
     return JWT::decode($token, self::$key, self::$encryption);
  }

  public function GetData($token)
  {
    return self::GetPayload($token)->data;
  }
}
