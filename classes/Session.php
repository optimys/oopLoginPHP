<?php
class Session{
    /**
     * ПРоверка существования сессиии
     *
     * @param $name     имя сессии
     * @return bool     возвращает правду или лож в зависимости от того есть ли сессия с указанным именем
     */
    public static function exists($name){
        return (isset($_SESSION[$name])) ? true : false ;
    }

    /**
     * Устанавливает сессию и ее значение
     *
     * @param $name     имя сессии
     * @param $value    значение которое будет записанно в сессию $name
     * @return mixed
     */
    public static function put($name, $value){
        return $_SESSION[$name] = $value;
    }

    /**
     * Возвращает значение указанной сессии
     *
     * @param $name     имя сессии
     * @return mixed    значение записанное в сессию $name которое будет возвращено
     */
    public static function get($name){
        return $_SESSION[$name];
    }

    /**
     * Удаляет сессию по имени
     *
     * @param $name     имя сессии
     */
    public static function delete($name){
        if(self::exists($name)){
            unset($_SESSION[$name]);
        }
    }

    /**
     * Временное сообщение, например об удачной авторизации или регистрации
     *
     * @param $name             имя сессии в котрую будем что-то писать ИЛИ которую будем удалять
     * @param string $string    текст который будет записан в сессию $name
     * @return string           В любом случаее возвращаем либо значение сессии либо пустую строку
     */
    public static function flash($name, $string=""){
        if(self::exists($name)){
            $session = "<div class='alert alert-success' role='alert'>".self::get($name)."</div>";
            self::delete($name);
            return $session;
        }else{
            self::put($name,$string);
        }
        return "";
    }
}