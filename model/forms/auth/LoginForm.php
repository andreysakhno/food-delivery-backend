<?php
namespace model\forms\auth;

use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логін або поштова адреса',
            'password' => "Пароль",
            'rememberMe' => "Запам'ятати",
        ];
    }
}
