<?php

/**
 * Class Hash
 * Класс для работы с паролями при записи в БД
 */
class Hash{
    /**
     * Создает уникальную комбинацию из пароля и соли
     *
     * @param $string       пароль
     * @param string $salt  соль
     * @return string       возвращаемая зашифрованная строка
     */
    public static function make($string, $salt = ''){
        return hash('sha256', $string . $salt);
    }

    /**
     * Генерирует каждый раз уникальную соль
     *
     * @param $length   разряднось шифра что-ли
     * @return string   возвращаемое значение, похоже на алфавит инопланетян
     */
    public static function salt($length){
        return utf8_encode(mcrypt_create_iv($length));
    }

    /**
     * Что-то что пока не пригодилось
     *
     * @return string
     */
    public static function unique(){
        return self::make(uniqid());
    }
}