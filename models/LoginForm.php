<?php

namespace app\models;

use Yii;
use yii\base\Model;
use linslin\yii2\curl;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $register = 0;
	private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
			['username', 'required', 'message' => 'Insert a username '],
            ['password', 'required', 'message'=> 'Insert a password '],
			['username', 'filter', 'filter'=>'strtolower'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
			[['username'], 'filter', 'filter' => 'trim'],
			['username', 'email'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates username and password.
     * This method serves as the inline validation for username and password.
     *
     * @param string $attribute the attribute currently being validated
     * @return mixed
     */
    public function validatePassword($attribute)
    {
		$config = require __DIR__ . '/../config/web.php';
        if(!$this->hasErrors()) {
            $user = $this->getUser();
			
            if($user) {
                // if user exists in the database
				if(!$user->getDisabled()) {
					// user ok
					if($this->validateUsernameRadius()) {
					    // user unimi?
						if($this->validatePasswordRadius() || $config['params']['bypass']) {
							return 1;
						}
						else {
							 $this->addError($attribute, 'User Not Allowed');
						}
					}
					else {
						if($user->validatePassword($this->password)) {
						    // user not coming from radius protocol but present in the database
							return 1;
						}
						else {
						// user inserted wrong password
						 $this->addError($attribute, 'User Not Allowed');
						 // go back to login ==> user found but wrong password
						}
					}
				}
				else {
					// user unabled
                    $this->addError($attribute, 'User disabled, contact admin at '.$config['params']['admin_contact']);
					}
			}
			else {
				// user not found in the database
				if($this->validatePasswordRadius() || $config['params']['bypass']) {
					// present in radius protocol
					$this->register = $config['params']['authradius'];								
					return 1;
				}
				else {
					$this->addError($attribute, 'User not found ');
				}
			}
		}
        return null;
	}

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
		$config = require __DIR__ . '/../config/web.php';
		
        if($this->validate()) {
			if($this->register == 100) {
				$this->register = 0;
				return $config['params']['authradius'];
            }
			if(Yii::$app->user->login($this->getUser(), $this->rememberMe ? (3600 * 24 * 30) : 0)) {
					return 1;
					// return true ==> go to the landing page
			}
		}
		else {
			return 0;
		}
		return null;
	}

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

    /**
     * Check if username is in the radius
     *
     * @return bool
     */
	public function validateUsernameRadius()
    {
		$config = require __DIR__ . '/../config/web.php';
        $radius_suffix = $config['params']['radius_suffix'];

        return $this->usernameEndsWith($radius_suffix); 
	}

    /**
     * Check if password is in the radius
     *
     * @return mixed
     */
	public function validatePasswordRadius()
    {
        $config = require __DIR__ . '/../config/web.php';
        $radius_host = $config['params']['radius_host'];
        $radius_suffix = $config['params']['radius_suffix'];

		if($this->usernameEndsWith($radius_suffix)) {
			$curl = new curl\Curl();
				return $curl->setPostParams([
					'username' => $this->username,
					'password' => $this->password
				])
					->post($radius_host);
		}
		return false;
	}

    /**
     * Check if username ends with a certain param
     *
     * @param $needle
     * @return bool
     */
    public function usernameEndsWith($needle)
    {
        $length = strlen($needle);

        return $length === 0 ||
            (substr($this->username, -$length) === $needle);
    }
}
