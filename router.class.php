<?php
    class Router {
        private $routes;
        private $route;
        private $params;
        private $dest;

        function __construct($routes, $route){
            
            $this->route  = $route;
            $res = [];
            foreach($routes as $index => $rs)
                if(isset($rs[2]))
                    for($i = 0; $i < count($rs[2]); $i++)
                        array_push($res, [str_replace("?", $rs[2][$i],$rs[0]), $rs[1]] );
                else array_push($res, $rs);
            
            $this->routes = $res;
        }
        function getParams(){
            return $this->params;
        }
        function getDest(){
            return $this->dest;
        }
        function execRouting(){
            $match = -1;
            $rexp = explode("/",$this->route);
            

            unset($rexp[0]);
            foreach($this->routes as $index => $rs){
                $rsexp = explode("/",$rs[0]);
                unset($rsexp[0]);
                $this->params = [];
                $success = true;    

                if(count($rsexp) == count($rexp)){
                    for($i = 1; $i < count($rexp)+1; $i++){

                        if(strlen($rsexp[$i]) > 0 && $rsexp[$i]{0} == ":"){
                            array_push($this->params, $rexp[$i]);    
                        }else{
                            if( $rsexp[$i] != $rexp[$i] ){
                                $success = false;
                                break;
                            }
                        }
                    }
                    if($success) {
                        $match = $index;
                        break;
                    } 
                }
            }

            $this->dest = ($match > -1)? $this->routes[$match][1]:"public/404.php";
            return $this->params;
            /*if($match > -1){
                require $this->routes[$match][1];
            }else{
                require "public/404.php";
            }*/
        }
    }
?>