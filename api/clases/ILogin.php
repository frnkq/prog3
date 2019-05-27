<?php
interface ILogin
{
    public function SignIn($request, $response, $args);
    public function ChangePassword($request, $response, $args);
}
    