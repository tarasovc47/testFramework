<?php

namespace model;

use core\DbModel;

class User extends DbModel
{
    public $id;
    public $name;
    public $login;
    public $password;
    public function getTable()
    {
        return 'users';
    }
    public function primaryKey()
    {
        return 'id';
    }
    public function fields()
    {
        return [
            'id',
            'name',
            'login',
            'password',
        ];
    }
    public static function findByLogin($login)
    {
        return User::find()->where(['login' => $login])->one();
    }
    public function create()
    {
        $this->password = md5($this->password);
        return $this->save(false);
    }
    public function validatePassword($password)
    {
        return $this->password == md5($password);
    }
}