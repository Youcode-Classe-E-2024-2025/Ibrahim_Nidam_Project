<?php
    namespace Model;
    use Model\MainModel;

    class UserModel extends MainModel{
        private $table = "person";

        public function getAllUsers() {
            return $this->read($this->table, ["role" => "Member"]);
        }
        
    }