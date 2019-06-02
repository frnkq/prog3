<?php
//include __DIR__."/../clases/Login.php";
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

return function($request, $response, $next)
{
  Login::SignIn($request, $response, $next);
  $response->getBody()->write("hola from middleware<br>");
  $next($request, $response);
  $response->getBody()->write("<br>chau from middleware<br>");
  return $response;
};
