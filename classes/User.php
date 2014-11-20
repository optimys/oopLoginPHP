<?php

/**
 * Class User Создает объект и заполняет таблицу
 */
class User{

    private  $db;       //Индификатор подключения к БД
    private  $_data;    //Здесь мы храним массив с данными о пользователе
    private $_sessionName;  //Храним имя сессии
    private $_isLoggedIN;

    /**
     * Конструктор, обращается к классу DB (синглтон), получает ссылку на обект ДБ
     * переменной $db присваевается эта ссылка
     * Здесь же записываем в переменную имя сессии, что не писать постоянно Config::get('ses******')
     */
    public  function __construct($user = null){
        $this->db = DB::getInstance();
        $this->_sessionName = Config::get('session/session_name');

        if(!$user){
            if(Session::exists($this->_sessionName)){
                $user = Session::get($this->_sessionName);
                if($this->find($user)){
                    $this->_isLoggedIN = true;
                }else{
                    //Logout
                }
            }
        }else{
            $this->find($user);
        }
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

    /**
     * @param null $username Имя пользователя которое ввели в фоме логинизации
     * @param null $password Пароль пользователя которое ввели в фоме логинизации
     * @return bool Возвращаем тру так как в login.php у нас есть проверка что возвращает метод тру или Фалсе
     */
    public function login($username=null, $password=null){          //По умолчанию все равно NULL
        $user = $this->find($username);                             //Проверяем есть ли такое имя?
        if($user){
            if($this->data()->password=== Hash::make($password, $this->data()->salt)){
                Session::put($this->_sessionName, $this->_data->id);            //Записываем в Сессию "user" значение id
                return true;
            }                                                                   //вернувшегося объекта
        }
        return false;
    }

    /**
     * Возвращает свойство в котором содержиться *ССЫЛКА* на объект с данными пользователя
     * @return _data    *ССЫЛКА* на объект с данными пользователя
     */
    public  function data(){
        return $this->_data;
    }

    public function isLoggedIn(){
        return $this->_isLoggedIN;
    }
}