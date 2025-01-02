<?php
    namespace Utilities;

    class CSRF {
        
        public static function getToken(){
            if(session_status() === PHP_SESSION_NONE){
                session_start();
            }

            if(empty($_SESSION["csrf_token"])){
                $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
            }

            return $_SESSION["csrf_token"];
        }

        public static function validateToken($token){
            if(session_status() === PHP_SESSION_NONE){
                session_start();
            }

            if(isset($_SESSION["csrf_token"]) && hash_equals($_SESSION["csrf_token"], $token)){
                $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
                return true;
            }

            return false;
        }
    }
