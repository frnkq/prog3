<?php
class DecodifyJson
{
    static function JsonToArray($content)
    {
        if(!DecodifyJson::isJson($_SERVER['CONTENT_TYPE']))
            return null;

        //Attempt to decode the incoming RAW post data from JSON.
        $arrayObjetos = json_decode($content, true);

        //If json_decode failed, the JSON is invalid.
        if(!is_array($arrayObjetos))
        {
            return null;
            //throw new Exception('Received content contained invalid JSON!');
        }

        return $arrayObjetos;
    }

    static function isJson($serverContentType)
    {
        $type = isset($serverContentType) ? trim($serverContentType) : "";
        if(strcasecmp($type, "application/json") != 0)
        {
            return false;
        }
        return true;
    }
}
