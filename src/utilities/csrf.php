<?php
    namespace Utilities;

    class CSRF {
        public static function getToken(string $formName): string {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            if (!isset($_SESSION["csrf_tokens"]) || !is_array($_SESSION["csrf_tokens"])) {
                $_SESSION["csrf_tokens"] = [];
            }

            $tokenLifeTime = 300;

            if (!isset($_SESSION["csrf_tokens"][$formName]) || 
                !is_array($_SESSION["csrf_tokens"][$formName]) || 
                !isset($_SESSION["csrf_tokens"][$formName]['time']) ||
                !isset($_SESSION["csrf_tokens"][$formName]['value']) ||
                time() - $_SESSION["csrf_tokens"][$formName]['time'] > $tokenLifeTime) {
                
                $_SESSION["csrf_tokens"][$formName] = [
                    'value' => bin2hex(random_bytes(32)),
                    'time' => time()
                ];
            }

            return $_SESSION["csrf_tokens"][$formName]['value'];
        }

        public static function validateToken(string $formName, string $token): bool {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            if (!isset($_SESSION["csrf_tokens"]) || 
                !is_array($_SESSION["csrf_tokens"]) ||
                !isset($_SESSION["csrf_tokens"][$formName]) ||
                !is_array($_SESSION["csrf_tokens"][$formName]) ||
                !isset($_SESSION["csrf_tokens"][$formName]['value'])) {
                return false;
            }

            $valid = hash_equals($_SESSION["csrf_tokens"][$formName]['value'], $token);
            if ($valid) {
                unset($_SESSION["csrf_tokens"][$formName]);
            }
            
            return $valid;
        }
    }