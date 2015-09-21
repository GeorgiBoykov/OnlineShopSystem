<?php

namespace MVCFramework;

class DbAdapter
{
    private $_db = null;
    private $_connectionString = null;
    private $_username = null;
    private $_password = null;
    private $_config = null;

    public function __construct($connectionString = null, $username = null, $password = null){
        $this->_config = Config::getInstance();
        $this->setConnectionData($connectionString, $username, $password);
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

    private function setConnectionData($connectionString, $username, $password){
        if($connectionString){
            $this->_connectionString = $connectionString;
        } else {
            $this->_connectionString = $this->_config->db['default']['connection_string'];
        }

        if($username){
            $this->_username = $username;
        } else {
            $this->_username = $this->_config->db['default']['username'];
        }

        if($password){
            $this->_password = $password;
        } else {
            $this->_password = $this->_config->db['default']['password'];
        }
    }

    private function getConnectionData(){
        if(is_null($this->_connectionString) || is_null($this->_username)|| is_null($this->_password)){
            throw new \Exception('Missing db connection data');
        }

        return array($this->_connectionString, $this->_username, $this->_password);
    }

    public function getEntity($fromTable, $whereEntityKeyValue){
        $entityColumnWhere = array_keys($whereEntityKeyValue)[0];
        $entityColumnWhereValue = $whereEntityKeyValue[$entityColumnWhere];
        $sql = "SELECT * FROM $fromTable WHERE $entityColumnWhere = '$entityColumnWhereValue'";
        $query = $this->_db->prepare($sql);

        try {
            $query->execute();
            $entity = $query->fetch();
            return $entity;
        } catch (\PDOException $e){
            echo $e->getMessage();
        }
    }

    public function getAllEntities($fromTable, $limit = null){
        $sql = "SELECT * FROM $fromTable";

        if(!is_null($limit)){
            $sql = "SELECT * FROM $fromTable LIMIT $limit";
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

    public function updateEntity($inTable, $updateColumnData, $whereEntityKeyValue){
        $updateColumn = array_keys($updateColumnData)[0];
        $updateValue = $updateColumnData[0];

        $entityColumnWhere = array_keys($whereEntityKeyValue)[0];
        $entityColumnWhereValue = $whereEntityKeyValue[$entityColumnWhere];

        $this->_db->beginTransaction();

        $sql = "UPDATE $inTable SET $updateColumn = '$updateValue' WHERE $entityColumnWhere = '$entityColumnWhereValue'";

        $query = $this->_db->prepare($sql);
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

        $sql = "DELETE FROM $inTable WHERE $entityColumnWhere = '$entityColumnWhereValue'";

        $query = $this->_db->prepare($sql);
        try {
            $query->execute();
        } catch (\PDOException $e){
            echo $e->getMessage();
        }
        $this->_db->commit();
    }
}