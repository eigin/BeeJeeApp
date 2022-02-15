<?php
/**
 *  Users_model class for BeeJeeTest app
 *  @author @eigins
 */


namespace model;


class Users_model extends Base_model
{

    /**
    * проверка логина/пароля пользователя
    */
    public function checkUserLogPass (array $param)
    {
        // фильтруем и экранируем данные
        $param = $this->__paramFilter($param);

        // запрос к БД
        $queryString = "
            SELECT id_user
            FROM user
            WHERE name = '{$param['login']}'
            AND password = '{$param['password']}'
        ";
        
        return $this->__getResult($queryString);

    }




}	