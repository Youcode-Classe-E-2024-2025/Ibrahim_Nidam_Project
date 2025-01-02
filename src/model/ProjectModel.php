<?php
    namespace Model;

    class ProjectModel extends MainModel{
        private $table = "project";

        public function getAllProjects(){
            return $this->read($this->table);
        }
    }