<?php

/**
 * Class Validate
 * Проверяет корректность введенных данных
 * По итогу в его объекте, в свойстве $_passed
 * будет значение либо false-проверка не прошла
 * либо true проверка прошла успешно
 */
class Validate
{
    private $_passed = false,      // Переключатель Зарешистрирован/Отказ-Ошибка
        $_errors = array(),    // Сюда будут попадать все ошибки из цикла проверки, и эту переменную будет выводить специальная функция.
        $_db = null;           //Наш ресурс к БД

    /**
     * Конструктор класса,
     * при инициализации
     * записывает в переменную $_db индификатор соединения с БД
     */
    public function __construct()
    {
        $this->_db = DB::getInstance();
    }

    /**
     * @param $source Тип отправки GET/POST
     * @param array $items Массив условий для заполняемых полей
     * @return $this Объект класса
     */
    public function check($source, $items = array())
    {
        foreach ($items as $item => $rules) {
            foreach ($rules as $rule => $rule_value) {

                $value = trim($source[$item]);                   //Убираем лишние пробелы на всякий случай, так как хрен его знает как вводили

                if ($rule === 'required' && empty($value)) {      // Сразу проверяем обязательные поля, так как дальше проверять нет смысла
                    $this->addError("{$item} is required");
                } else {                                          //Если обязательные поля заполнены продолжаем проверку
                    switch ($rule) {
                        case 'min':
                            if (strlen($value) < $rule_value) {
                                $this->addError("{$item} must be minimum {$rule_value} characters");
                            }
                            break;
                        case 'max':
                            if (strlen($value) > $rule_value) {
                                $this->addError("{$item} must be maximum {$rule_value} characters");
                            }
                            break;
                        case 'matches':
                            if ($value != $source[$rule_value]) {
                                $this->addError("{$rule_value} must match {$item}");
                            }
                            break;
                        case 'unique':
                            $check = $this->_db->get($rule_value, array($item, '=', $value)); //Запрос к БД
                            if ($check->count()) {                                            // Если в ответе есть данные, значить такая запись уже есть.
                                $this->addError("This {$item} already exist, please choose another");
                            }
                            break;
                        default:
                            break;
                    }
                }
            }
        }

        if (empty($this->_errors)) {
            $this->_passed = true;
        }

        return $this;
    }

    /**
     * Функция для заполнения переменной $_errors ошибками
     * @param $error текст  ошибки который будет отправлен в массив ошибок
     */
    private function addError($error)
    {
        $this->_errors[] = $error;
    }

    /**
     * Эта функция выводить все ошибки в цикле
     * из массива $_errors
     */
    public function errors()
    {
        foreach ($this->_errors as $error) {
            echo "<h5 class='text-warning'><span class='label label-warning'>Warning</span>{$error}</h5>";
        }
    }

    /**
     * @return bool Просто возвращает переменную $_passed
     * которая будет true если проверка прошла успешно и false если есть ошибки
     */
    public function passed()
    {
        return $this->_passed;
    }
}