<?php
namespace Users\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter\InputFilter;

class LoginForm extends Form
{
    public function __construct()
    {
        parent::__construct();

        $this->addElement();
        $this->validateForm();
    }
    
    private function addElement()
    {
        $this->add([
            'name' => 'username',
            'type'=>'text',
         
            'attributes' =>[
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Tên đăng nhập: ',
                'id' => 'username'
            ],
        ]);

        $this->add([
            'name' => 'password',
            'type'=>'password',
         
            'attributes' =>[
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Mật khẩu: ',
                'id' => 'password'
            ],
        ]);
        
        $this->add([
            'type' => 'checkbox',
            'name' => 'remember',
            'options' => [
                'label' => 'Ghi nhớ mật khẩu ',
                
            ],
        ]);

        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            
            'attributes' =>[
                'class' => 'btn btn-primary',
                'value' => 'Đăng nhập'
            ],
        ]);
        
    }

    public function validateForm()
    {
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        $inputFilter->add([
            'name' => 'username',
            'required' => true,
            'filters' => [
                ['name'=>'StringTrim'],
                ['name'=>'StripTags'],
                ['name'=>'StringToLower'],
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'messages' => [
                            \Zend\Validator\NotEmpty::IS_EMPTY => "Username không thể để trống",
                        ],
                    ],
                ],
            ],   
        ]);

        $inputFilter->add([
            'name' => 'password',
            'required' => true,
            'filters' => [
                ['name'=>'StringTrim'],
                ['name'=>'StripTags'],
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'messages' => [
                            \Zend\Validator\NotEmpty::IS_EMPTY => "Mật khẩu không thể để trống",
                        ],
                    ],
                ],
            ],
        ]);
    }
}
?>