<?php
require_once("vendor/autoload.php");
use App\Controller\UserController;

// Assignin routes from routes.php;
$routes = require_once('routes.php');

//routes array ထဲမှာ path ပါလားမပါလားစစ် ပြီး ပါရင် အဲ့ path နဲ့သက်မှတ် ထားတဲ့ controller ထဲက method က အလုပ်လုပ်မယ်။
if(isset($_SERVER['PATH_INFO'])){
    $path = $_SERVER['PATH_INFO'];
       
    if(array_key_exists($path,$routes)){
        $db = $routes[$path][0];
        $method = $routes[$path][1];
        $user = new $db();
        $user->$method();
    }
}else{
    $user = new UserController();
    $user->index();
}