<?php
namespace Zend\Validator;
use Traversable;

class ConfirmPassword extends AbstractValidator
{
    const NOT_EQUAL = "not_equal";
    
     /**
     * @var array
     */
    protected $messageTemplates = [
        self::LENGTH => 'Mật khẩu không giống nhau!',
    ];

      /**
     * @var array
     */
    protected $messageVariables = [
        'confirm_password'    => ['options' => 'confirm_password'],
    ];

    protected $options = [
        'confirm_password'    => ''
    ];

    public function __construct($options)
    {

        if (! is_array($options)) {
            $options     = func_get_args();
            $temp['confirm_password'] = array_shift($options);

            $options = $temp;
        }

        parent::__construct($options);
    }


    /**
     * Returns the min option
     *
     * @return String
     */
    public function getConfirmPassword()
    {
        return $this->options['confirm_password'];
    }

    public function setConfirmPassword($confirmPassword)
    {
        $this->options['confirm_password'] = $confirmPassword;
        return $this;
    }
    

    /**
     * Returns true if and only if $value is contained in the haystack option. If the strict
     * option is true, then the type of $value is also checked.
     *
     * @param mixed $value
     * See {@link http://php.net/manual/function.in-array.php#104501}
     * @return bool
     */
    public function isValid($value)
    {
        $this->setValue($value);
        $isValid = true;
        if(strlen($value)<8){
            $this->error(self::LENGTH);
            $isValid = false;
        }
         if(!preg_match('/[A-Z]/', $value)){
            $this->error(self::UPPER);
            $isValid = false;
        }
        
         if(!preg_match('/[a-z]/', $value)){
            $this->error(self::LOWER);
            $isValid = false;
        }
        
         if(!preg_match('/[0-9]/', $value)){
            $this->error(self::DIGIT);
            $isValid = false;
        }
        
         if(!preg_match('/[!@#$%^&;:*,.]/', $value)){
            $this->error(self::SPECIAL_CHARACTER);
            $isValid = false;
        }
        
        return $isValid;
    }
}

?>