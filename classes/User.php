<?php

/**
 * Class User Создает объект и заполняет таблицу
 */
class User{
    /**
     * @var DB|null     идентификатор подключения к БД
     */
    private  $db;

    /**
     * Конструктор, обращается к классу DB (синглтон), получает ссылку на обект ДБ
     * переменной $db присваевается эта ссылка
     *
     */
    public  function __construct(){
        $this->db=DB::getInstance();
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
}