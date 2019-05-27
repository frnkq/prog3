<?php

require __DIR__."/../middleware/MWLogin.php";
use \Slim\App;

return function(App $app)
{
  $app->group('/login', function()
  {
    $this->post('/', \Login::class . ':SignIn');
    $this->put('/', \Login::class . ':ChangePassword');
  })->add(\MWLogin::class . ':sayHi');
};
