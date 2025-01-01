<?php

    namespace Connection;

    use PDO;
    use PDOException;

    class Database {
        private $host = "localhost";
        private $dbname = "Kanban_Project_db";
        private $user = "root";
        private $pass = "";
        public $db;

        public function __construct(){
            $this->startSession();
        }

        private function startSession(){
            if(session_status() === PHP_SESSION_NONE){
                session_start();
            }
        }

        public function getConnection(){
            try{
                $dsn = "mysql:host=$this->host;";
                $this->db = new PDO($dsn, $this->user, $this->pass);
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $this->db->prepare("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = :dbname");
                $stmt->execute([':dbname' => $this->dbname]);
                $dbExists = $stmt->fetch();

                if(!$dbExists){
                    $this->db->exec("CREATE DATABASE $this->dbname");
                    $this->db->exec("USE $this->dbname");
                    $this->initializeDatabase();
                    
                } else {
                    $this->db->exec("USE $this->dbname");
                }

                return $this->db;
            } catch (PDOException $e){
                error_log("Database connection Error: " . $e->getMessage());
                die("An error occurred. Please try again later.");
            }
        }

        private function initializeDatabase(){
            try{
                $sql = file_get_contents(__DIR__ .'/../../assets/database/script.sql');
                if ($sql === false) {
                    throw new PDOException("Unable to read script.sql file.");
                }
                $this->db->exec($sql);
            } catch (PDOException $e){
                error_log("Database Initialization error: " . $e->getMessage());
                die("An error occurred. Please try again later.");
            }
        }
    }