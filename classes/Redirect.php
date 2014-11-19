<?php

/**
 * Класс для перенаправления, ну чтоб не использовать каждый раз header('location:')
 * Class Redirect
 */
class Redirect{
    public static function  to($location=null){             //По умолчанию пустая переменная
        if($location){                                      //Если она не пустая, продолжаем
            if(is_numeric($location)) {                     //Она содержит число, значит редирект на ошибку
                switch($location){                          //Что же число ?
                    case 404:                               // 404, значит направляем заголовки
                        header('HTTP/1.0 404 Not Found');   // Заголовки ошибки
                        include('includes/errors/404.php'); //Включаем файл с текстом ошибки
                        exit();                             //Уходим
                    break;                                  //Дольше, так же можно добавить другие коды ошибок,
                }                                           //и соответствующие им страницы с текстом.
            }
            header('Location: ' . $location . '.php');      // в переменной текст, значи перенаправляем на страничку
            exit();
        }
    }
}