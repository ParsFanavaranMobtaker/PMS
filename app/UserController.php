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
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller implements ControllerProviderInterface
{
    var $app;
    public function connect(Application $app) {
        $this->app = $app;
        $factory = $app['controllers_factory'];// Routes are defined here
        
        $factory->post('login', function (Request $request) use ($app){
            return $this->login($request);
        });
        $factory->get('foo','MyApp\UserController::doFoo');
        return $factory;
    }
    public function login(Request $request) {
        $username = $request->request->get('username');
        $password = $request->request->get('password');
        $sql = "SELECT * FROM user WHERE username = '$username' LIMIT 1";
        $res = $this->app['db']->fetchAll($sql);
        if (count($res) == 1) {
            $user = $res[0];
            $token = md5($res[0]['id'] . date_timestamp_get(date_create()) . rand(0,100000));
            $sql = "INSERT INTO token (id, token, user_id, create_time, expire_time) 
                     VALUES (NULL, '$token',$user[id],NOW(),NOW() + INTERVAL 1 YEAR)";
            $this->app['db']->executeUpdate($sql);
            return $this->response(["token"=>$token, "userId"=>$user['id']]);
        }
        return $res;
    }
    public function doFoo() {
        return 'Bar';
    }

}