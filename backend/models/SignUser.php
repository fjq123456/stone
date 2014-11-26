<?php
namespace backend\models;

use Yii;
use common\models\User;


/**
 * Signup form
 */
class SignUser extends User
{
    public $sex = 1;
    public $status = 10;

    public $auth;
    public $defaultPassword = '123456';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required', 'message'=>'用户名不可为空'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => '此用户名已被使用'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required', 'message'=>'邮箱不可为空'],
            ['email', 'email', 'message'=>'请填入正确的邮箱地址'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => '该邮箱已注册'],
            ['realname', 'safe']
        ];
    }
    public function sign()
    {
        $this->setPassword($this->defaultPassword);
        $this->generateAuthKey();
        if($this->save()){
            return $this;
        }
        return false;
    }

    public function addRoles($roles)
    {
        $auth = Yii::$app->authManager;
        if (is_array($roles)) {
            foreach ($roles as $role_name) {
                $role = $auth->getRole($role_name);
                $auth->assign($role, $this->id);
            }
        }
    }
}
