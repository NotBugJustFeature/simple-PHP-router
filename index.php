<?php
    require_once "router.class.php";
    $publicDir = "public";
    $apiDir = "api";

    $routes = [
        ["/",                   "{$publicDir}/index.php"],  
        ["/about",              "{$publicDir}/about.php"],
        ["/user/:parameter",    "{$publicDir}/user.php"],
    ];

    $router = new Router($routes, $_SERVER['REQUEST_URI'], "{$publicDir}/404.php", Router::BOTH);
    $_PARAMS = $router->execRouting();
    require $router->getDest();
    //echo $router->getDest()."<br>";
    //print_r($_PARAMS);

    /*
        Router(routeList, current route, paramlist type = [ARRAY, ASSOC, BOTH])
        $routes = [
            ["urlDest",                 "dirDest"],  
            ["urlDest/:parameter",      "dirDest"], will be stored in the $_PARAMS array
            ["urlDest/:parameter",      "{$publicDir}/user.php",     
        ]; 
    */
    

?>
