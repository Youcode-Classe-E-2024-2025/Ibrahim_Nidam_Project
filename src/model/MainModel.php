<?php
    namespace Model;
    use Connection\Database;

    class MainModel{
        protected $db;

        public function __construct(){
            $database = new Database();
            $this->db = $database->getConnection();
        }
    }