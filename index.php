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
        'dbname' => 'pms',
        'host' => 'localhost',
        'user' => 'root',
        'password' => 'salam',
        'charset' => 'utf8'
    ),
));

$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

// Controller
$app->mount('/user', new MyApp\UserController());

$app->run();