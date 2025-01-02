<?php
    namespace Controller;

    use Controller\MainController;
    use Model\UserModel;
    use Utilities\CSRF;

    class UserController extends MainController {

        public function signup(){
            if($_SERVER["REQUEST_METHOD"] === "POST"){

                if(!isset($_POST["csrf_token"]) || !CSRF::validateToken($_POST["csrf_token"])){
                    die("Invalid CSRF Token");
                }

                $name = $_POST["full-name"];
                $email = $_POST["email"];
                $password = $_POST["password"];

                if(!preg_match("/^[A-Za-z\s]+$/", $name)){
                    exit;
                }
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    exit;
                }
                if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password)){
                    exit;
                }
                
            }
            
            $csrf_token = CSRF::getToken();
            require_once "../src/view/sections/register.php";
        }

        public function login(){
            
            if($_SERVER["REQUEST_METHOD"] === "POST"){

                if(!isset($_POST["csrf_token"]) || !CSRF::validateToken($_POST["csrf_token"])){
                    die("Invalid CSRF Token");
                }

                $email = $_POST["email"];
                $password = $_POST["password"];

                $userModel = new UserModel();
                $user = $userModel->read("person", ["email" => $email]);

                if($user && password_verify($password, $user[0]["password"])){
                    session_start();
                    $_SESSION["user"] = $user[0]["id"];
                    $_SESSION["user_name"] = $user[0]["name"];
                    header("Location: ?action=home");
                    exit;
                }else {
                    echo "<script>alert('Invalid Email or Password')</script>";
                }
            }

            $csrf_token = CSRF::getToken();
            require_once "../src/view/sections/login.php";
        }
    }