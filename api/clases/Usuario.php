<?php

class Usuario
{
    public $id;
    public $username;
    public $password;

    public function GetAllUsers()
    {
        $pdo = PDOSingleton::GetPdo();
        $query = "SELECT * FROM Usuarios";
        $result = $pdo->ReturnQuery($query);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_CLASS, "Usuario");
    }

    public function GetUserById($id)
    {
        $pdo = PDOSingleton::GetPdo();
        $query = "SELECT * FROM Usuarios where id=$id";
        $result = $pdo->ReturnQuery($query);
        $result->execute();
        $user = $result->fetchObject("Usuario");
        return $user;
    }

    public function GetUserByUsernameAndPassowrd($username, $password)
    {
        $pdo = PDOSingleton::GetPdo();
        $result = $pdo->ReturnQuery("SELECT * FROM Usuarios where username=:username and password=:password");
        $result->bindValue(':username', $username, PDO::PARAM_STR);
        $result->bindValue(':password', $password, PDO::PARAM_STR);
        $result->execute();
        $user = $result->fetchObject("Usuario");
        return $user;
    }

    public function Create($request, $response, $args)
    {
        $pdo = PDOSingleton::GetPdo();
        $query = $pdo->ReturnQuery("INSERT INTO Usuarios(username, password) values (:username, :password)");
        $query->bindValue(':username', $this->username, PDO::PARAM_STR);
        $query->bindValue(':password', $this->password, PDO::PARAM_STR);
        $query->execute();
        return $pdo->GetLastId();
    }

    public function Update($request, $response, $args)
    {
        $pdo = PDOSingleton::GetPdo();
        $query = $pdo->ReturnQuery("UPDATE Usuarios SET username=:username, password=:password where id=:id");
        $query->bindValue(":id", $this->id, PDO::PARAM_INT);
        $query->bindValue(":username", $this->username, PDO::PARAM_STR);
        $query->bindValue(":password", $this->password, PDO::PARAM_STR);
        return $query->execute();
        
    }

    public function UpdatePassword($newPassword)
    {
        $pdo = PDOSingleton::GetPdo();
        $query = $pdo->ReturnQuery("UPDATE Usuarios SET password=:password where id=:id");
        $query->bindValue(":id", $this->id, PDO::PARAM_INT);
        $query->bindValue(":password", $newPassword, PDO::PARAM_STR);

        return $query->execute();
    }

    public function Delete($request, $response, $args)
    {
        $pdo = PDOSingleton::GetPdo();
        $query = $pdo->ReturnQuery("DELETE FROM Usuarios where id=:id");
        $query->bindValue(":id", $this->id, PDO::PARAM_INT);
        return $query->execute();
    }
}