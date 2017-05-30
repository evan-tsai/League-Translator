<?php

namespace common\models;

use Yii;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;

/**
 * This is the model class for table "administrators".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_salt
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $last_logon_ip
 * @property integer $last_logon_time
 */
class Administrators extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'administrators';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_salt', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_at', 'updated_at', 'last_logon_time'], 'integer'],
            [['username', 'password_salt'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['last_logon_ip'], 'string', 'max' => 40],
            [['username'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_salt' => 'Password Salt',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'last_logon_ip' => 'Last Logon Ip',
            'last_logon_time' => 'Last Logon Time',
        ];
    }


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
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
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_salt);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_salt = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @inheritdoc
     * @return AdministratorsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdministratorsQuery(get_called_class());
    }
}