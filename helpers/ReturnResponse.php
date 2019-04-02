<?php

function ReturnResponse($success, $errorCode, $object)
{
  $result = array(
    'Result' => $success,
    'Object' => $object
  );

  if(!$success)
    $result["ErrorCode"] = $errorCode;

  return json_encode($result);
}
