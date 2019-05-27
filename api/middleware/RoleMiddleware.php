<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Slim\App;

return function ($request, $response, $next) {
   
    $response->getBody()->write($response->getBody());
    
    $params = $request->getParsedBody();
    $role=$params['role'];

    if($role == "admin")
    {
        $response = $next($request, $response);
    }
    else
    {
        $response->getBody()->write("you need to be an admin");
    }
    return $response;  
  };