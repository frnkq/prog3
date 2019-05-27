<?php

class PDOSingleton
{
    private static $accessObject;
    private $pdoObject;

    private function __construct()
    {
        try
        {
            $host = "localhost";
            $dbname = "usuarios";
            $username = "root";
            $password = "";
            $this->pdoObject = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8', $username, $password, array(PDO::ATTR_EMULATE_PREPARES => false,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            $this->pdoObject->exec("SET CHARSET utf8");
        }
        catch(Exception $e)
        {
            print "Error ".$e->getMessage();
            die();
        }
    }

    public function ReturnQuery($sql)
    {
        return $this->pdoObject->prepare($sql);
    }

    public function GetLastId()
    {
        return $this->pdoObject->lastInsertId();
    }

    public function GetPdo()
    {
        if(!isset(self::$accessObject))
        {
            self::$accessObject = new PDOSingleton();
        }
        return self::$accessObject;
    }

    public function __clone()
    {
        triger_error("El objeto PDO no puede ser clonado", E_USER_ERROR);
    }
}