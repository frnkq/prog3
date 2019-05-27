<?php

function ProcessRequest()
{
  $get = null;
  $post = array();
  if(isset($_GET))
  {
    $get = array();
    $get["nombre"] = isset($_GET['nombre']) ? $_GET['nombre'] : null;
    $get["edad"] = isset($_GET['edad']) ? $_GET['edad'] : null;
    $get["dni"] = isset($_GET['dni']) ? $_GET['dni'] : null;
    $get["legajo"] = isset($_GET['legajo']) ? $_GET['legajo'] : null;

  }
  if(isset($_POST))
  {
    $post = array();
    $post["nombre"] = isset($_POST['nombre']) ? $_POST['nombre'] : null;
    $post["edad"] = isset($_POST['edad']) ? $_POST['edad'] : null;
    $post["dni"] = isset($_POST['dni']) ? $_POST['dni'] : null;
    $post["legajo"] = isset($_POST['legajo']) ? $_POST['legajo'] : null;
    $post["foto"] = isset($_FILES['foto']) ? $_FILES['foto'] : null;
    $post["apellido"] = isset($_POST['apellido']) ? $_POST['apellido'] : null;
  }

  return array("get" => $get, "post" => $post);
}
