<?php

require_once 'ILogin.php';
require_once 'Usuario.php';

class Login implements ILogin
{
    public function SignIn($request, $response, $args)
    {
        $params = $request->getParsedBody();

        $username = $params["username"];
        $password = $params["password"];        
        $user = Usuario::GetUserByUsernameAndPassowrd($username, $password);
        if(!$user)
        {
            return $response->withJson("Invalid username or password", 400);
        }
        return $response->withJson("Logged in :) ", 200);
    }

    public function ChangePassword($request, $response, $args)
    {
        $params = $request->getParsedBody();

        $username = $params["username"];
        $password = $params["password"];
        $newPassword = $params["newpassword"];    
        $user = Usuario::GetUserByUsername($username);
        if(!$user || ($user->password != $password) )
        {
            return $response->withJson("Invalid username or password", 400);
        }

        $user->updatePassword($newPassword);

        return $response->withJson("Password changed", 200);
    }
}