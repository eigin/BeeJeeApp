<?php
/**
 *  Users class for BeeJeeTest app
 *  @author @eigins
 */


namespace controller;
use model\Users_model;


class Users
{
    protected $_model;
    
    public function __construct ()
	{
        // подключим модель и контроллер шаблонов
        $this->_model = new Users_model;
        $this->_view = new View;
	}
    /**
    * авторизация пользователя
    */
    public function login (array $param)
    {

        // валидация обязательных полей ввода
        if(!isset($param['login'])) return ['status'=>'error', 'msg'=>'не введен логин'];
        if(!isset($param['password'])) return ['status'=>'error', 'msg'=>'не введен пароль'];

        // выбор параметров для модели
        $params['login'] = $param['login'];
        
        // получим хэш пароля
        $params['password'] = md5(md5($param['password']));

        // запрос к модели
        $checkUserLogPass = $this->_model->checkUserLogPass($params);

        // предупреждение
        if (!$checkUserLogPass) return ['status'=>'error', 'msg'=>'неверный логин или пароль'];

        // авторизуем и переходит на начальную страницу
        $_SESSION['logged'] = true;
        header ('Location: /');

    }


    /**
    * открыть форму авторизации пользователя
    */
    public function showLoginForm (array $param)
    {
        $this->_view->renderTemplate('Login_view.php', []);
    }


    /**
    * отмена авторизации пользователя
    */
    public function logout (array $param)
    {
        unset($_SESSION['logged']);
    }


}	