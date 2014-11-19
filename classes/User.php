<?php

/**
 * Class User Создает объект и заполняет таблицу
 */
class User{

    private  $db;       //Индификатор подключения к БД
    private  $_data;    //Здесь мы храним массив с данными о пользователе
    private $_sessionName;  //Храним имя сессии

    /**
     * Конструктор, обращается к классу DB (синглтон), получает ссылку на обект ДБ
     * переменной $db присваевается эта ссылка
     */
    public  function __construct(){
        $this->db = DB::getInstance();
        $this->_sessionName = Config::get('session/session_name');
    }

    /**
     * Создает пользователя в БД
     *
     * @param array         $fields массив полей в которые будет вестись запись
     * @throws Exception    выкидываем ошибку если вставка не удалась
     *
     */
    public function create($fields=array()){

        if(!$this->db->insert('users',$fields)){
            throw new Exception("There was a problem creating your account");
        }
    }

    public function find($user=null){
        if($user){
            $field = (is_numeric($user) ? "id" : "username");
            $data = $this->db->get('users',array($field,'=',$user));

            if($data->count()){
                $this->_data = $data->first();                      //Возвращается объект PDO
                return true;
            }
        }
        return false;
    }

    public function login($username=null, $password=null){
        $user = $this->find($username);                             //Проверяем есть ли такое имя?
        if($user){
            if($this->data()->password=== Hash::make($password, $this->data()->salt)){
                Session::put($this->_sessionName, $this->_data->id);            //Записываем в Сессию "user" значение id
            }                                                                   //вернувшегося объекта
        }
        return false;
    }

    /**
     * Возвращает свойство в котором содержиться *ССЫЛКА* на объект с данными пользователя
     * @return _data    *ССЫЛКА* на объект с данными пользователя
     */
    private function data(){
        return $this->_data;
    }
}