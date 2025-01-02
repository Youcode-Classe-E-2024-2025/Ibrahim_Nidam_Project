<?php
    namespace Controller;

    use Controller\MainController;
    use Model\UserModel;

    class UserController extends MainController {

        public function signup(){
            
            require_once "../src/view/sections/register.php";
        }

        public function login(){
            
            if($_SERVER["REQUEST_METHOD"] === "POST"){
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
            require_once "../src/view/sections/login.php";
        }
    }