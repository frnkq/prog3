<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Slim\App;

return function ($request, $response, $next) {
    $response->getBody()->write("Verificando rol<br>");

    $params = $request->getParsedBody();
    $role=$params['role'];
    $username = $params["username"];
    $password = $params["password"];

    if($role == "admin")
    {
         //login
        $response->getBody()->write("iniciando sesion...<br>");
        $next($request, $response)->getBody();
        $result = Usuario::GetUserByUsernameAndPassowrd($username, $password);
        if($result)
        {
          $response->getBody()->write("<h3>Hola ".$request->getParsedBody()['username']."</h3>");
          $respone = $next($request, $response);
        }
        else
        {
          $response->getBody()->write("usuario/contrasena invalido");
        }
      }
    else
    {
        $response->getBody()->write("<br>you need to be an admin");
    }
    $response->getBody()->write("<br>saliendo del verificador");
    return $response;
  };
