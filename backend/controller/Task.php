<?php
/**
 *  Task class for BeeJeeTest app
 *  @author @eigins
 */


namespace controller;
use model\Task_model;


class Task
{
    protected $_model;

    public function __construct ()
	{
        // подключим модель и контроллер шаблонов
        $this->_model = new Task_model;
        $this->_view = new View;
	}



    /**
    * получить страницу задач (3 задачи на странице)
    */
    public function getPage ($param)
	{
        // выбор параметров для модели
        $params['page_num'] = $param['page_num'] ?? 1;
        $params['order_by'] = $param['order_by'] ?? 'id_task';
        $params['direction'] = $param['direction'] ?? 'ASC';

        // запрос к модели
        $templateData = $this->_model->getPage($params);

        // страница по умолчанию
        if (!$param) {
            $this->_view->renderTemplate('Base_view.php', $templateData);
        } else {
            $this->_view->renderTemplate('Task_view.php', $templateData);
        }
	}


    /**
    * получить данные задачи для редактирования
    */
    public function getTask ($param)
	{

        // страница по умолчанию
        if (!$param) {
            $this->_view->renderTemplate('Base_view.php', $templateData);
        } else {
            $this->_view->renderTemplate('Task_view.php', $templateData);
        }
	}


    /**
    * открыть форму добавления задачи
    */
    public function showEditTaskForm (array $param)
    {
        $templateData = [];
        
        // если есть код задачи, значит это редактирование, получим данные
        if (isset($param['id_task']) && $param['id_task']) {

            // выбор параметров для модели
            $params['id_task'] = $param['id_task'];
            
            // запрос к модели
            $templateData = $this->_model->getTask($params);

        }

        $this->_view->renderTemplate('Edit_view.php', $templateData);
    }


    /**
    * сохранить задачу
    */
    public function saveTask (array $param)
    {

        // массив сообщений при валидации обязательных полей
        $validMsg = ['name' => 'не введено имя', 'email' => 'email некорректный',
            'task' => 'не введена задача'];

        // подготовка параметров для модели
        if (isset($param['id_task']) && $param['id_task']) $params['id_task'] = $param['id_task'];

        // валидация обязательных полей
        foreach ($validMsg as $key => $value) {
            if (!isset($param[$key]) || !$param[$key]) return ['status' => 'error', 'msg'=> $value];
            if ($key == 'email' && !filter_var($param[$key], FILTER_VALIDATE_EMAIL)) return ['status' => 'error', 'msg'=> $value];
            $params[$key] = $param[$key];
        }

        // запрет для незалогиненого пользователя изменять статус и редактировать задачу
        if(isset($_SESSION['logged'])) {
            $params['ready'] = $param['ready'] ?? 0;
            $params['edit'] = $param['edit'];
        }

        // запрос к модели
        return $this->_model->saveTask($params);
    }


}	