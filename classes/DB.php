<?php

/**
 * Класс который реализует патерн СИНГЛТОНА, тоесть объект только один
 *
 * Class DB
 */
class DB
{

    private static $_instance = null;
    private $_pdo,
        $_query,
        $_error = false,
        $_results,
        $_count = 0;

    private function __construct()
    {
        try {
            $this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
     * Всегда используем этот метод для того чтоб получить объект класса, или создать если он еще не был создан.
     * @return DB|null
     */
    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }

    public function query($sql, $params = array())
    {
        $this->_error = false;
        if ($this->_query = $this->_pdo->prepare($sql)) {
            $x = 1;
            if (count($params)) {
                foreach ($params as $param) {
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }

            if ($this->_query->execute()) {
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);      //ВОзвращаем Объект !!!!
                $this->_count = $this->_query->rowCount();
            } else {
                $this->_error = true;
            }

        }
        return $this;
    }

    public function action($action, $table, $where = array())
    {
        if (count($where) === 3) {
            $operators = array('<', '>', '=', '<=', '>=', '!=');
            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if (in_array($operator, $operators)) {
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
                if (!$this->query($sql, array($value))->error()) {
                    return $this;                                               // Возвращаем Объект !
                }
            }
        }
        return false;
    }

    public function insert($table, $fields = array())
    {
        if (count($fields)) {
            $keys = array_keys($fields);
            $input = implode("`, `", $keys);
            $x = 1;
            $values = "";
            foreach ($fields as $field) {
                $values .= "?";
                if ($x < count($fields)) {
                    $values .= ", ";
                    $x++;
                }
            }

            $sql = "INSERT INTO {$table} (`{$input}`) VALUES({$values}) ";
            if (!$this->query($sql, $fields)->error()) {
                return "Success!";
            }
        }
        return false;
    }

    public function update($table, $fields = array(), $id)
    {
        $values = "";
        $x = 1;
        foreach ($fields as $key => $value) {
            $values .= "{$key} = ?";
            if ($x < count($fields)) {
                $values .= ", ";
            }
            $x++;
        }

        $sql = "UPDATE {$table} SET {$values} WHERE id = {$id}";

        if (!$this->query($sql, $fields)->error()) {
            return true;
        } else {
            return false;
        }
    }

    public function get($table, $where = array())
    {
        return $this->action("SELECT *", $table, $where);
    }

    public function delete($table, $where = array())
    {
        return $this->action('DELETE', $table, $where);
    }

    public function count()
    {
        return $this->_count;
    }

    public function results()
    {
        return $this->_results;
    }

    public function first()
    {
        return $this->results()[0];
    }

    public function error()
    {
        return $this->_error;
    }
}