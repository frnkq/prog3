<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Slim\App;

    

return function(App $app)
{
    $app->group('/login', function()
    {
        $this->post('/', \Login::class . ':SignIn');
        $this->put('/', \Login::class . ':ChangePassword');
    });
};