<?php
namespace Zend\Validator;
use Traversable;

class PasswordStrength extends AbstractValidator
{
    const LENGTH = "length";
    const LOWER = "lower";
    const UPPER = "upper";
    const DIGIT = "digit";
    const SPECIAL_CHARACTER = "specical_character";

     /**
     * @var array
     */
    protected $messageTemplates = [
        self::LENGTH => 'Mật khẩu ít nhất 8 ký tự',
        self::LOWER => 'Mật khẩu ít nhất 1 ký tự thường',
        self::UPPER => 'Mật khẩu ít nhất 1 ký tự hoa',
        self::DIGIT => 'Mật khẩu ít nhất 1 ký tự số',
        self::SPECIAL_CHARACTER => 'Mật khẩu ít nhất 1 ký tự đặc biệt "!@#$%^&*.;,"',
    ];

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