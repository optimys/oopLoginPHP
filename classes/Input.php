<?php
//Здесь мы проверяем какаой был запрос и был ли он с какими-то данными при нажатии на кнопку регистрации
class Input
{

    public static function exist($type = 'post')
    {
        switch ($type) {
            case 'post':
                return (!empty($_POST)) ? true : false;
                break;
            case 'get':
                return (!empty($_POST)) ? true : false;
                break;
            default :
                return false;
                break;
        }
    }

    public static function get($item)
    {
        if (isset($_POST[$item])) {
            return $_POST[$item];
        } elseif (isset($_GET[$item])) {
            return $_GET[$item];
        }
        return "";
    }
}

?>