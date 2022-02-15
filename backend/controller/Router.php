<?php
/**
 *	Router class for BeeJeeTest app
 *  @author @eigins
 */


class Router
{
    
    /**
    * основной контроллер
    */
    static function start()
    {

        // получим название контроллера
        $controller = $_POST['c'] ?? $_GET['c'] ?? '';

        // получим название метода
        $method = $_POST['m'] ?? $_GET['m'] ?? '';

        // получим параметры метода
        $param = $_POST['param'] ?? $_GET['param'] ?? [];

        // страница по умолчанию
        if (!$controller) {
            $controller = 'Task';
            $method = 'getPage';
            $param = [];
        }

        $controller = 'controller\\' . $controller;

        // автоподключение нужного файла класса
        spl_autoload_register ( function($className) {
            $fileName = $_SERVER['DOCUMENT_ROOT'] . '/../backend/' . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
            if (!file_exists ($fileName)) exit (json_encode(['status'=>'error','msg'=>'class file not found']));
            require $fileName;
        });

        if ($method) {
            // проверка существования указанного метода в контроллере
            $methodExist = method_exists($controller, $method);
            if (!$methodExist) exit (json_encode(['status'=>'error','msg'=>'method not found']));

            // запуск контроллера / метода / с параметрами
            $result = (new $controller)->$method($param);

        } else {
            $result = new $controller;
        }

        // возврат ответа в формате JSON
        if ($result) echo json_encode($result);

    }
}