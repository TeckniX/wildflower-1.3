<?php
/**
 * User model
 * 
 * Users are Wildflower`s administrator accounts.
 *
 * @todo Allow login to have chars like _.
 * @package wildflower
 */
class User extends AppModel {
	
	public $hasMany = array(
	    'Page',
	    'Post',
	);

    public $validate = array(
        'name' => array(
            'rule' => array('between', 1, 255),
            'allowEmpty' => false,
            'required' => true
        ),
	'login' => array(
		'rule' => array('custom', '/^[a-z0-9_.]{5,50}$/i'),
		'required' => true,
		'message' => 'Login must be between 5 to 50 alphanumeric characters long'
	),
	'password' => array(
            'between' => array(
                'rule' => array('between', 5, 50),
                'required' => true,
                'message' => 'Password must be between 5 to 50 characters long'
            ),
            'confirmPassword' => array(
                'rule' => array('confirmPassword'),
                'message' => 'Please enter the same value for both password fields'
            )
        ),
		'email' => array(
			'rule' => 'email',
			'required' => true,
			'message' => 'Please enter a valid email address'
		)
    );

    /**
     * Does password and password confirm match?
     *
     * @return bool true
     */
    function confirmPassword() {
        App::import('Security');
        $confirmPassword = $this->data[$this->name]['confirm_password'];
        $confirmPassword = Security::hash($confirmPassword, null, true);
        if ($confirmPassword !== $this->data[$this->name]['password']) {
            return false;
        }
        // if (!isset($this->data[$this->name]['id'])) {
        //     $this->data[$this->name]['password'] = $confirmPassword;
        // }
        return true;
    }

}
