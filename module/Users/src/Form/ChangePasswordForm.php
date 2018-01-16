<?php
namespace Users\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter\InputFilter;


class ChangePasswordForm extends Form
{
    private $isChangePassword;
    public function __construct($isChangePassword = true)
    {
        parent::__construct();
        $this->isChangePassword = $isChangePassword;
        $this->addElement();
        $this->validateForm();
    }

    private function addElement()
    {
        
        $this->add([
            'type'=>'password',
            'name' => 'old_pw',
            'attributes' =>[
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Mật khẩu cũ: '
            ],
        ]);

        $this->add([
            'type'=>'password',
            'name' => 'new_pw',
            'attributes' =>[
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Mật khẩu mới: '
            ],
        ]);

        $this->add([
            'type'=>'password',
            'name' => 'confirm_new_pw',
            'attributes' =>[
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Nhập lại mật khẩu mới: '
            ],
        ]);
            //csrf
        $this->add([
            'type'=>'csrf',
            'name' => 'csrf',
            'options' => [
                'csrf_options' =>[
                    'timeout' => 600
                ]
            ],
        ]);

    
        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => [
                'class' => 'btn btn-primary',
                'value' => 'OK'
            ]
        ]);
    }

    public function validateForm()
    {
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        
            $inputFilter->add([
                'name' => 'old_pw',
                'required' => $this->isChangePassword,
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
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'min' => 6,
                            'max' => 20,
                            'messages' => [
                                \Zend\Validator\StringLength::TOO_LONG => 'Mật khẩu không được vượt quá %max% ký tự!',
                                \Zend\Validator\StringLength::TOO_SHORT => 'Mật khẩu phải ít nhất %min% ký tự!'
                            ],
                        ],
                    ],
                    [
                        'name' => 'Regex',
                        'options' => [
                            'pattern'=>'/[A-Z0-9a-z_-]/',
                            'messages'=>[
                                \Zend\Validator\Regex::INVALID   => "Mật khẩu không hợp lệ",
                                \Zend\Validator\Regex::NOT_MATCH => "Mật khẩu không đúng mẫu '%pattern%'",
                                \Zend\Validator\Regex::ERROROUS  => "Mât khẩu lỗi nội bộ khi dùng '%pattern%'",  
                            ],
                        ],
                    ]
                ]
            ]);

            $inputFilter->add([
                'name' => 'new_pw',
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
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'min' => 6,
                            'max' => 20,
                            'messages' => [
                                \Zend\Validator\StringLength::TOO_LONG => 'Mật khẩu không được vượt quá %max% ký tự!',
                                \Zend\Validator\StringLength::TOO_SHORT => 'Mật khẩu phải ít nhất %min% ký tự!'
                            ],
                        ],
                    ],
                    [
                        'name' => 'Regex',
                        'options' => [
                            'pattern'=>'/[A-Z0-9a-z_-]/',
                            'messages'=>[
                                \Zend\Validator\Regex::INVALID   => "Mật khẩu không hợp lệ",
                                \Zend\Validator\Regex::NOT_MATCH => "Mật khẩu không đúng mẫu '%pattern%'",
                                \Zend\Validator\Regex::ERROROUS  => "Mât khẩu lỗi nội bộ khi dùng '%pattern%'",  
                            ],
                        ],
                    ]
                ]
            ]);

            $inputFilter->add([
                'name' => 'confirm_new_pw',
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
                                \Zend\Validator\NotEmpty::IS_EMPTY => "Hãy xác nhận mật khẩu",
                            ],
                        ],
                    ],
                    [
                        'name' => 'Identical',
                        'options' => [
                            'token' => 'new_pw',
                            'messages' => [
                                \Zend\Validator\Identical::NOT_SAME  => "Mật khẩu không trùng nhau",
                                \Zend\Validator\Identical::MISSING_TOKEN  => "MISSING TOKEN",
                            ],
                        ]
                    ]
                ]
            ]);
        
        
    }
}

?>