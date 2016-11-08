<?php
/**
 * Created by PhpStorm.
 * User: funfullson
 * Date: 10/29/16
 * Time: 1:29 PM
 */

use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . '/vendor/autoload.php';

$app = new Silex\Application();

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'dbname' => 'school',
        'host' => '192.168.88.11',
        'user' => 'developer',
        'password' => '123',
        'charset' => 'utf8'
    ),
));

$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

$app->get('/hello/{name}', function ($name) use ($app) {
    return 'Hello '.$app->escape($name);
});

$app->post('/login', function (Request $request) use ($app) {
    $content = $request->getContent();
    print_r($request->request);
    $national_code = $request->get('national_code');
    $res = $app['db']->fetchAll("SELECT * FROM person WHERE national_code = '$national_code'");
    if (strlen($national_code) == 10) {
        return $app->json(["token" => "123456", "content" => $content, "result" => json_encode($res)],200,["cookie"=>"aaa=123"]);
    }
    return $app->json(["message" => "login failed"], 403);
});

$app->run();