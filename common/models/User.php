<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = -1;//删除
    const STATUS_WAIT = 5; //待激活
    const STATUS_ACTIVE = 10; //活跃

    const ROLE_USER = 10;

    const SEX_MALE = 1;
    const SEX_FEMALE = 2;
    const SEX_SECRET = 3;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function getRoles()
    {
        $roles= Yii::$app->authManager->getRoles();
        return yii\helpers\ArrayHelper::map($roles, 'name', 'name');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'required'],
            [['email'], 'email'],
            ['sex', 'default', 'value' => self::SEX_MALE],
            ['sex', 'in', 'range' => [self::SEX_MALE, self::SEX_FEMALE, self::SEX_SECRET]],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED, self::STATUS_WAIT]],
            ['role', 'default', 'value' => self::ROLE_USER],
            // ['role', 'in', 'range' => [self::ROLE_USER]],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public static function getNameById($user_id)
    {
        return static::findOne(['id' => $user_id])->username;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'sex'   => '性别',
            'realname' => '真实姓名',
            'email' => '邮箱',
            'status' => '状态',
            'created_at' => '添加时间',
            'sextext' => '性别',
            'statustext' => '状态',
            'updated_at' => '最后更新',
            'userrole' => '用户角色'
        ];
    }

    public static function getSex($sex='')
    {
        $sexs = [
            self::SEX_MALE => '男',
            self::SEX_FEMALE => '女',
            self::SEX_SECRET => '保密'
        ];
        return $sexs;
    }

    public static function getStatus()
    {
        $status = [
            self::STATUS_WAIT => '待激活',
            self::STATUS_ACTIVE => '活跃',
            self::STATUS_DELETED=> '删除'
        ];
        return $status;
    }

    public function getSexText()
    {
        $sexs = self::getSex();
        return $sexs[$this->sex];
    }

    public function getStatusText()
    {
        $statuses = self::getStatus();
        return $statuses[$this->status];
    }

    public function getUserRole()
    {
        $roles = Yii::$app->authManager->getRolesByUser($this->id);
        return implode(',', array_keys($roles));
    }
}
