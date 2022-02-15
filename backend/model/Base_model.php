<?php
/**
 *  Base class for BeeJeeTest app
 *  @author @eigins
 */

// session_start();

namespace model;
use config\Config;


class Base_model
{
    protected static $_db = null;

    public function __construct ()
    {
        $this->__ConnectDb();
    }


    /**
    * подключение БД mySql с параметрами из конфига
    */
    protected function __ConnectDb ()
    {
        if (self::$_db) return self::$_db; // уже подключено
        $db = Config::$db;
        self::$_db = new \mysqli($db['host'], $db['user'], $db['pass'], $db['name'], $db['port']);
        if (self::$_db->error) die ('Connect Error '.self::$_db->connect_error);

        return self::$_db->set_charset('UTF8');
    }


    /**
    * Получаемые параметры фильтруем от нежелательных SQL инъекций и html тегов
    */
    protected function __paramFilter (array $param)
    {
        if(!$param) return;

        foreach ($param as $key => $value) {

            // переведём полученные важные числовые ключевые поля обратно в числа
            if($key=='id' || strpos($key,'id_')) { $value = (int)$value; }

            // уберём нежелательные символы, отсечем мультизапросы и теги
            $no_symbol = array('$','%','^','|',';',':','-','~','`','&','=','<','>','[',']','#');
            $value = str_replace($no_symbol, '', $value);

            // экранируем оставшиеся нужные спецсимволы для исключения ошибок при записи в таблицу
            // используем UTF8 (установлено при подключении к БД) защищаемся от символов в другой кодировке
            $param[$key] = self::$_db->real_escape_string($value);
        }

        return $param;
    }


    /**
    * получить по сформированному запросу данные в виде ассоциативного массива
    */
    protected function __getResult (string $queryString)
    {
        $array_data = [];
        $results = self::$_db->query($queryString) or die(mysqli_error(self::$_db));
        $array_data = $results->fetch_all(MYSQLI_ASSOC);
        $results->free();

        return $array_data;
    }


}
