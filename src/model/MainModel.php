<?php
    namespace Model;

    use Connection\Database;
    use PDO;
    
    class MainModel{
        protected $db;

        public function __construct(){
            $database = new Database();
            $this->db = $database->getConnection();
        }

        public function read($table, $conditions = []){
            $sql = "SELECT * FROM {$table}";
            
            if(!empty($conditions)){
                $where = [];
                foreach($conditions as $key => $value){
                    $where[] = "{$key} = :{$key}";
                }
                $sql .= " WHERE " . implode(" AND ", $where);
            }

            $stmt = $this->db->prepare($sql);
            $stmt->execute($conditions);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }