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
    function response($status, Array $data = [], $message = '')
    {
        $response = new JsonResponse();
        $response->setEncodingOptions(JSON_NUMERIC_CHECK);
        $data = json_encode($data);
        $res = ['status' => $status, 'data' => $data, 'message' => $message];
        $response->setData($res);
        return $response;
    }
}