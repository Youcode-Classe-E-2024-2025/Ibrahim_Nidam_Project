<?php   
    namespace Controller;

    class ProjectController extends MainController{
        protected $MainController;

        public function __construct(){
            $this->MainController = new MainController();
        }

    }