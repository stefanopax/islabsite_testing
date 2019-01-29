<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property string $username
 * @property string password
 * @property string $authkey
 * @property string $name
 * @property string $surname
 * @property boolean $is_disabled
*/
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
			[['username'], 'required'],
            [['authkey', 'name', 'surname'], 'required'],
            [['is_disabled'], 'boolean'],
            [['username', 'password', 'name', 'surname'], 'string', 'max' => 350],
            [['authkey'], 'string', 'max' => 350],
            [['username'], 'unique'],
		 ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'authkey' => 'Authkey',
            'name' => 'Name',
            'surname' => 'Surname',
            'is_disabled' => 'Is Disabled',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);		// 'is_disabled' => 0
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authkey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authkey === $authKey;
    }

    /**
     * @param string $password
     * @return void
     * @throws \yii\base\Exception
     */
	public function setPassword($password)
    {
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($password);
    }

    /**
     * @param string $username
     * @return void
     */
	public function setUsername($username)
    {
        $this->username = $username;
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
     * @return string
     */
	public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
	public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @return string
     */
	public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return bool
     */
	public function getDisabled()
	{
		return $this->is_disabled;
	}

    /**
     * @return void
     * @throws \yii\base\Exception
     */
	public function generateAuthKey()
    {
        $this->authkey = Yii::$app->security->generateRandomString();
    }

    /**
     * @param string $name
     * @return void
     */
	public function setName($name)
	{
		$this->name = $name;
	}

    /**
     * @param string $surname
     * @return void
     */
	public function setSurname($surname)
	{
		$this->surname = $surname;
	}

    /**
     * @param bool $param
     * @return void
     */
	public function setDisabled($param)
	{
		$this->is_disabled = $param;
	}

    /**
     * @param integer $id
     * @return void
     */
	public function softDelete($id)
	{
		$this->is_disabled = true;
		$this->save();
	}

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }
	
	/**
     * roleBasedHomePage
     *
     * @return mixed
     */
	public function roleBasedHomePage() {
		 
		$role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->id);
		// however you define your role, you'll have an output value in this variable
		if(isset($role['admin'])) {
			return '/admin'; 
		}
		else {
			if(isset($role['staff'])) {
				return '/staffhome'; 
			}
			else {
				if(isset($role['teacher'])) {
					return '/teacher'; 
				}
				else {
					if(isset($role['student'])) {
					    return 'site/studenthome';
					}
				}
			}
		}
		return null;
	}
}
