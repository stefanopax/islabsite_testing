<?php

namespace app\models;

use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class RegisterForm extends Model
{
    public $username;
    public $password;
    public $name;
    public $surname;
	public $register_id;

   public function rules()
    {
        return [
            // username and password are both required
            [['username','register_id'], 'required'],  // verify unique constraints, password and username must not be already used
			['name', 'required' , 'message' => ' Insert a name '],
			['surname', 'required' , 'message' => ' Insert a surname '],

            // rememberMe must be a boolean value
            //['rememberMe', 'boolean'],
			[['name','surname'], 'filter', 'filter' => 'trim'],
			['register_id', 'match', 'pattern' => '/^\d{6}$/', 'message' => 'Field must contain exactly 6 digits.'],
        ];
    }

    /**
     * function register
     * @param integer $username
     * @return int 1 for correct login
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function register($username)
    {
		$user = new User();
		$student = new Student();
		$user->setUsername($username);
		$user->generateAuthKey();
		$user->setName($this->name);
		$user->setSurname($this->surname);
			if($user->save()) {
				$student->setId($user->getId());
				$student->setRegister($this->register_id);
				if($student->save()) {
					$temp = new Usertemp();
					$temp->deleteByUsername($username);
					return 1; 
				}
				else {
					$user->delete();
					// insert into student failed (ERROR MESSAGE)
					return 0;
				}
			}
			else
			    return 0;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
