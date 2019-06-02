<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Slim\App;

require_once 'clases/JWT.php';

return function(App $app)
{
    $app->group('/usuarios', function () {

      $this->get('/', \UsuarioAPI::class . ':GetAll');
      $this->post('/x', \UsuarioAPI::class . ':GetAll')
            ->add(
                 function ($request, $response, $next) {
                   $response->getBody()->write("Verificando token<br>");

                   $token = $request->getHeaders()["HTTP_TOKEN"];
                   if(JWTAuth::VerifyToken($token))
                   {
                      $response->getBody()->write("holis :) ");
                   }
                   else
                   {
                     $response->getBody()->write("x( ");
                   }
                   return $response;
                   }
                 );

                 $this->get('/{id}', \UsuarioAPI::class . ':GetOne');

                 $this->post('/', \UsuarioAPI::class . ':Create');

                 $this->put('/', \UsuarioAPI::class . ':Update');

                 $this->delete('/', \UsuarioAPI::class . ':Delete');
               });
};
