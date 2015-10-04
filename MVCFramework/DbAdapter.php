<?php

namespace MVCFramework;

class DbAdapter
{
    private static $_instance = null;
    private $_db = null;
    private $_connectionString = null;
    private $_username = null;
    private $_password = null;
    private $_config = null;

    protected function __construct(){
        $this->_config = Config::getInstance();
        $this->setConnectionData();
        $connectionData = $this->getConnectionData();
        try {
            $this->_db = new \PDO(
                $connectionData[0], $connectionData[1], $connectionData[2],
                array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
        } catch (\PDOException $ex){
            echo "<br>No connection with database";
            die;
        }
    }

    public static function getInstance(){
        if(self::$_instance == null){
            self::$_instance = new DbAdapter();
        }

        return self::$_instance;
    }

    private function setConnectionData(){
        if(is_null($this->_config->db)){
            throw new \Exception("Missing 'db' configuration file.");
        }
        $this->_connectionString = $this->_config->db['default']['connection_string'];
        $this->_username = $this->_config->db['default']['username'];
        $this->_password = $this->_config->db['default']['password'];
    }

    private function getConnectionData(){
        if(is_null($this->_connectionString) || is_null($this->_username)|| is_null($this->_password)){
            throw new \Exception('Missing db connection data');
        }

        return array($this->_connectionString, $this->_username, $this->_password);
    }

    public function query($sql, $params = null){
        $query = $this->_db->prepare($sql);

        try {
            $query->execute($params);
            $entities = $query->fetchAll();
            return $entities;
        } catch (\PDOException $e){
            echo $e->getMessage();
        }
    }

    public function getEntityById($fromTable, $id){
        $sql = "SELECT * FROM $fromTable WHERE id = ?";

        $query = $this->_db->prepare($sql);
        $query->bindParam(1, $id);
        try {
            $query->execute();
            $entity = $query->fetch();
            return $entity;
        } catch (\PDOException $e){
            echo $e->getMessage();
        }
    }

    public function getEntityPropertyById($fromTable, $id, $property){
        $sql = "SELECT $property FROM $fromTable WHERE id = ?";

        $query = $this->_db->prepare($sql);
        $query->bindParam(1, $id);
        try {
            $query->execute();
            $entity = $query->fetch();
            return $entity;
        } catch (\PDOException $e){
            echo $e->getMessage();
        }
    }

    public function getEntitiesByCriteria($fromTable, $whereEntityKeyValue, $orderBy = null, $ascOrDesc = 'asc', $limit = null){
        $entityColumnWhere = array_keys($whereEntityKeyValue)[0];
        $entityColumnWhereValue = $whereEntityKeyValue[$entityColumnWhere];
        $sql = "SELECT * FROM $fromTable WHERE $entityColumnWhere LIKE ?";

        if(!is_null($orderBy)){
            $sql.= " ORDER BY '$orderBy' $ascOrDesc";
        }

        if(!is_null($limit)){
            $sql .= " LIMIT $limit";
        }

        $query = $this->_db->prepare($sql);
        $query->bindParam(1, $entityColumnWhereValue);

        try {
            $query->execute();
            $entities = $query->fetchAll();
            return $entities;
        } catch (\PDOException $e){
            echo $e->getMessage();
        }
    }

    public function getAllEntities($fromTable, $limit = null, $orderBy = null, $ascOrDesc = 'asc'){
        $sql = "SELECT * FROM $fromTable";

        if(!is_null($orderBy)){
            $sql.= " ORDER BY $orderBy $ascOrDesc";
        }

        if(!is_null($limit)){
            $sql .= " LIMIT $limit";
        }

        $query = $this->_db->prepare($sql);

        try {
            $query->execute();
            $entities = $query->fetchAll();
            return $entities;
        } catch (\PDOException $e){
            echo $e->getMessage();
        }
    }

    public function insertEntity($inTable, $insertData){

        function placeholders($text, $count=0, $separator=","){
            $result = array();
            if($count > 0){
                for($x=0; $x<$count; $x++){
                    $result[] = $text;
                }
            }

            return implode($separator, $result);
        }

        $this->_db->beginTransaction();
        $insert_values = array();
        foreach($insertData as $d){
            $question_marks[] =  placeholders('?', sizeof($d));
            array_push($insert_values, $d);
        }

        $sql = "INSERT INTO $inTable (" . implode(",", array_keys($insertData) ) . ") VALUES (" . implode(',', $question_marks).')';

        $query = $this->_db->prepare($sql);
        try {
            $query->execute($insert_values);
        } catch (\PDOException $e){
            echo $e->getMessage();
        }
        $this->_db->commit();
    }

    public function updateEntity($inTable, $updateData, $whereEntityKeyValue){
        $entityColumnWhere = array_keys($whereEntityKeyValue)[0];
        $entityColumnWhereValue = $whereEntityKeyValue[$entityColumnWhere];

        function placeholders($text, $count=0, $separator=","){
            $result = array();
            if($count > 0){
                for($x=0; $x<$count; $x++){
                    $result[] = $text;
                }
            }

            return implode($separator, $result);
        }

        $this->_db->beginTransaction();
        $update_values = array();
        foreach($updateData as $d){
            $question_marks[] =  placeholders('?', sizeof($d));
            array_push($update_values, $d);
        }

        $sql = "UPDATE $inTable SET (" . implode(",", array_keys($updateData) ) . ")
        VALUES (" . implode(',', $question_marks).") WHERE $entityColumnWhere = ?";

        $query = $this->_db->prepare($sql);
        $query->bindParam(1, $entityColumnWhereValue);
        try {
            $query->execute($update_values);
        } catch (\PDOException $e){
            echo $e->getMessage();
        }
        $this->_db->commit();
    }

    public function updateEntityProperty($inTable, $updateColumnData, $whereEntityKeyValue){
        $updateColumn = array_keys($updateColumnData)[0];
        $updateValue = $updateColumnData[$updateColumn];

        $entityColumnWhere = array_keys($whereEntityKeyValue)[0];
        $entityColumnWhereValue = $whereEntityKeyValue[$entityColumnWhere];

        $this->_db->beginTransaction();

        $sql = "UPDATE $inTable SET $updateColumn = '$updateValue' WHERE $entityColumnWhere = ?";

        $query = $this->_db->prepare($sql);
        $query->bindParam(1, $entityColumnWhereValue);
        try {
            $query->execute();
        } catch (\PDOException $e){
            echo $e->getMessage();
        }
        $this->_db->commit();
    }

    public function deleteEntity($inTable, $whereEntityKeyValue){
        $entityColumnWhere = array_keys($whereEntityKeyValue)[0];
        $entityColumnWhereValue = $whereEntityKeyValue[$entityColumnWhere];

        $this->_db->beginTransaction();

        $sql = "DELETE FROM $inTable WHERE $entityColumnWhere = ?";

        $query = $this->_db->prepare($sql);
        $query->bindParam(1, $entityColumnWhereValue);
        try {
            $query->execute();
        } catch (\PDOException $e){
            echo $e->getMessage();
        }
        $this->_db->commit();
    }
}