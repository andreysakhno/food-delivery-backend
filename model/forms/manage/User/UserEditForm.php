<?php

namespace model\forms\manage\User;

use model\entities\User\User;
use yii\base\Model;
use Yii;

class UserEditForm extends Model
{
    public $username;
    public $email;
    public $password;

    public $_user;

    public function __construct(User $user, $config = [])
    {
        $this->username = $user->username;
        $this->email = $user->email;
        $this->_user = $user;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['username', 'email'], 'trim'],
            [['username', 'email'], 'required'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'string', 'max' => 255],

            ['username', 'unique', 'targetClass' => User::class, 'filter' => ['<>', 'id', $this->_user->id], 'message' => 'Це ім\'я користувача вже зайняте.'],
            ['email', 'unique', 'targetClass' => User::class, 'filter' => ['<>', 'id', $this->_user->id], 'message' => 'Ця електронна адреса вже зайнята.'],

            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логін',
            'email' => 'Поштова адреса',
            'password' => "Пароль",
        ];
    }
}