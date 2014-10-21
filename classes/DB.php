<?php
class DB{
    private $_pdo;
    private static $_instance = null;

    private function __construct(){
        try{
           $this->_pdo = new PDO('mysql:host='.Config::get('mysql/host').';dbname=' .Config::get('mysql/db'),Config::get('mysql/username'), Config::get('mysql/password'));
            echo "Connected";
        }
        catch(PDOException $e){
            die($e->getMessage());
        }
    }

    public static function getInstance(){
        if( !isset(self::$_instancee) ){
            self::$_instance = new DB();
        }
        return self::$_instance;
    }
}