<?php
/**
 *  Task_model class for BeeJeeTest app
 *  @author @eigins
 */


namespace model;


class Task_model extends Base_model
{

    /**
    * получим задачи для выбранной страницы
    */
    public function getPage (array $param)
    {
        // фильтруем и экранируем данные
        $param = $this->__paramFilter($param);

        // добавим сортировку и пагинацию
        $orderBy = $param['order_by'] ?? '';
        $direction = $param['direction'] ?? '';
        $order = $orderBy ? ('ORDER BY ' . $orderBy . ' ' . $direction) : '';
        $from = ($param['page_num'] -1) * 3;

        // запрос к БД
        $queryString = "
            SELECT count(*) as cnt
            FROM task
        ";
        $count_rec = $this->__getResult($queryString)[0]['cnt'] ?? 0;

        // запрос к БД
        $queryString = "
            SELECT *
            FROM task
            {$order}
            LIMIT 3 OFFSET {$from}
        ";
        $result[] = $this->__getResult($queryString);
        $result[] = ['order_by' => $orderBy, 'direction' => $direction, 'first_rec' => $from, 'count_rec' => $count_rec ];

        return $result;

    }


    /**
    * получим данные по задаче
    */
    public function getTask (array $param)
    {
        // фильтруем и экранируем данные
        $param = $this->__paramFilter($param);

        // запрос к БД
        $queryString = "
            SELECT *
            FROM task
            WHERE id_task = {$param['id_task']}
        ";
        return $this->__getResult($queryString);

    }


    /**
    * сохранение задачи
    */
    public function saveTask (array $param)
    {
        // фильтруем и экранируем данные
        $param = $this->__paramFilter($param);

        // подготовим поля
        $fields = implode(', ', array_keys($param));
        $values = "'" . implode("', '", array_values($param)) . "'";
        $where = '';

        // формируем строку запроса с учетом возможных экранированных кавычек
        $queryString = "INSERT INTO task ({$fields}) VALUES ({$values})";
        
        // если есть id_task, это редактирование - изменим запрос
        if (isset($param['id_task']) && $param['id_task']) {
            $where = ' WHERE id_task = ' . $param['id_task'];
            unset($param['id_task']);
            $set = [];
            foreach ($param as $key => $value) $set[] = $key . ' = "' . $value . '"';
            $queryString = 'UPDATE task SET ' . implode(', ', $set) . $where;
        }

        // запрос к БД
        self::$_db->query($queryString) or die(mysqli_error(self::$_db));

        // если добавление - вернём код новой записи, и наоборот
        if (!self::$_db->insert_id) return ['status'=>'success', 'msg'=>'Задача изменена'];
        return ['status'=>'success', 'msg'=>'Задача добавлена', 'insert_id'=>self::$_db->insert_id ];

    }


}	