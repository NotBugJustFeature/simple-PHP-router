<?php
    class Router {
        private $routes;
        private $route;
        private $params;
        private $dest;
        private $mode;

        const BOTH = 3;
        const ASSOC = 2;
        const ARRAY = 1;

        function __construct($routes, $route, $mode = self::ARRAY){
            $this->route    = $route;
            $this->mode     = $mode;
            $this->routes   = $routes;
            $res            = [];
        }
        function getDest(){
            return $this->dest;
        }
        function execRouting(){
            $match = -1;
            if(strpos($this->route, "?") != false) {
                $spl = explode("?", $this->route);
                $rexp = explode("/",$spl[0]);
            }else $rexp = explode("/",$this->route);

            unset($rexp[0]);

            foreach($this->routes as $index => $rs){
                $rsexp = explode("/",$rs[0]);
                unset($rsexp[0]);
                $this->params = [];
                $success = true;    

                if(count($rsexp) == count($rexp)){
                    for($i = 1; $i < count($rexp)+1; $i++){

                        if(strlen($rsexp[$i]) > 0 && $rsexp[$i][0] == ":"){
                            if(($this->mode & 1)) array_push($this->params, $rexp[$i]);
                            if(($this->mode>>1 & 1)) $this->params = array_merge($this->params, [substr($rsexp[$i], 1) => $rexp[$i]]);
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
        }
    }
?>