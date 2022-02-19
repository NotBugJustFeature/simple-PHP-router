<?php
    require_once "router.class.php";
    $publicDir = "public";
    $apiDir = "api";

    $routes = [
        ["/",               "{$publicDir}/index.php"],  
        ["/about",          "{$publicDir}/about.php"],
        ["/?/:parameter",   "{$publicDir}/user.php",     ["u","user"]],
    ];

    $router = new Router($routes, $_SERVER['REQUEST_URI']);
    $_PARAMS = $router->execRouting();
    require $router->getDest();

    /*
        $routes = [
            ["urlDest",             "dirDest"],  
            ["urlDest/:parameter",  "dirDest"], will be stored in the $_PARAMS array  
            ["/?/:parameter",       "{$publicDir}/user.php",     ["u","user"]], In parameter 3 you can create a alias, and ? shows the position of the alias.
        ]; 
    */
?>