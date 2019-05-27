<?php
require_once 'Usuario.php';
require_once 'IApi.php';

class UsuarioAPI extends Usuario implements IAPI
{
    public function GetAll($request, $response, $args)
    {
        $users = Usuario::GetAllUsers();
        return $response->withJson($users, 200);
    }
    public function GetOne($request, $response, $args)
    {
        $id = $args["id"];
        $user = Usuario::GetUserById($id);
        return $response->withJson($user, 200);
    }
    
    public function Create($request, $response, $args)
    {
        $params = $request->getParsedBody();
       
        $username = $params["username"];
        $password = $params["password"];        
        $user = new Usuario();
        $user->username = $username;
        $user->password = $password;
        
        $user->Create($request, $response, $args);

        return $response->withJson(["usuario" => $user, "message" => "Usuario creado"], 200);
    }

    public function Update($request, $response, $args)
    {
        $params = $request->getParsedBody();
        $user = new Usuario();
        $user->id = $params["id"];
        $user->username = $params["username"];
        $user->password = $params["password"];
        
        $result = $user->Update($request, $response, $args);

        return $response->withJson(["resultado" => $result, "nuevousuario" => $user], 200);
    }

    public function Delete($request, $response, $args)
    {
        $params = $request->getParsedBody();
        $user = new Usuario();
        $user->id = $params["id"];
        $user->username = $params["username"];
        $user->password = $params["password"];

        $userToDelete = Usuario::GetUserById($user->id);
        $result = $user->Delete($request, $response, $args);
        return $response->withJson(["resultado" => $result, "usuarioborrado" => $userToDelete], 200);

    }
}