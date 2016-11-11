<?php
/**
 * Created by PhpStorm.
 * User: mostafa
 * Date: 11/12/2016
 * Time: 12:41 AM
 */

namespace MyApp;


use Symfony\Component\HttpFoundation\JsonResponse;

abstract class Controller
{
    function response(Array $data)
    {
        $response = new JsonResponse();
        $response->setEncodingOptions(JSON_NUMERIC_CHECK);
        $response->setData($data);
        return $response;
    }
}