<?php

interface IAPI
{
    public function GetAll($request, $response, $args);
    public function GetOne($request, $response, $args);
    public function Create($request, $response, $args);
    public function Update($request, $response, $args);
    public function Delete($request, $response, $args);
}