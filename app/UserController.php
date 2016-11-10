<?php
/**
 * Created by PhpStorm.
 * User: funfullson
 * Date: 11/10/16
 * Time: 12:05 PM
 */

namespace MyApp;
use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use Silex\Api\ControllerProviderInterface;

class UserController implements ControllerProviderInterface
{
    public function connect(Application $app) {
        $factory = $app['controllers_factory'];// Routes are defined here
        $factory->post('login', function (Request $request) use ($app){
            return $this->login('salam');
        });
        $factory->get('foo','MyApp\UserController::doFoo');
        return $factory;
    }
    public function login($username) {
        return "Hello world $username";
    }
    public function doFoo() {
        return 'Bar';
    }

}