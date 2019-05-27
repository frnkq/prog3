<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Slim\App;

return function(App $app)
{
    $app->group('/usuarios', function () {
 
        $this->get('/', \UsuarioAPI::class . ':GetAll');
       
        $this->get('/{id}', \UsuarioAPI::class . ':GetOne');
      
        $this->post('/', \UsuarioAPI::class . ':Create');
      
        $this->put('/', \UsuarioAPI::class . ':Update');
      
        $this->delete('/', \UsuarioAPI::class . ':Delete');
           
      });
};