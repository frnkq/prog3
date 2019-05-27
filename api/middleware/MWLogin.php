<?php
//include __DIR__."/../clases/Login.php";

class MWLogin
{
  public function sayHi($request, $response, $next)
  {
    Login::SignIn($request, $response, $next);
    $response = $next($request, $response);
    $response->getBody()->write("chau from middleware");
    return $response;
  }
}
