<?php

/**
 * Class for working with cookie
 *
 * Class Cookie
 */
class Cookie{
    /**
     * Check if cookie is exist
     * @param $name name of the cookie
     * @return bool
     */
    public static  function exist($name){
        return (isset($_COOKIE[$name])) ? true : false;
    }

    /**
     * Get value of the cookie by name
     * @param $name name of the cookie
     * @return mixed
     */
    public static function get($name){
        return $_COOKIE[$name];
    }

    /**
     * Set new cookie with expire and path
     * @param $name     name of the cookie
     * @param $value    value of the cookie
     * @param $expiry   time to expire
     * @return bool
     */
    public static function put($name, $value, $expiry){
        if( setcookie($name, $value, time()+$expiry, '/') ){
            return true;
        }
        return false;
    }

    /**
     * Delete cookie by set it empty value
     * @param $name name of the cookie
     */
    public static function delete($name){
        self::put($name, "", time()-1);
    }
}