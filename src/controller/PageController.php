<?php
    namespace Controller;

    class PageController extends MainController {
        
        public function home(){
            require_once "../src/view/pojects.php";
        }
    }