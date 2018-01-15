<?php
namespace Users\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter\InputFilter;


class UserForm extends Form
{
    private $isAdd;

    public function __construct($isAdd = true)
    {
        parent::__construct();
        
        $this->isAdd = $isAdd;
     
        $this->addElement();
        $this->validateForm();
    }

    private function addElement()
    {
        $this->add([
            'name' => 'id',
            'type' => 'hidden'
        ]);

        $this->add([
            'name' => 'username',
            'type'=>'text',
         
            'attributes' =>[
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Username: ',
                'id' => 'username'
            ],
        ]);
        if($this->isAdd){
            $this->add([
                'type'=>'password',
                'name' => 'password',
                'attributes' =>[
                    'class' => 'form-control'
                ],
                'options' => [
                    'label' => 'Mật khẩu: '
                ],
            ]);

            $this->add([
                'type'=>'password',
                'name' => 'confirm_password',
                'attributes' =>[
                    'class' => 'form-control'
                ],
                'options' => [
                    'label' => 'Nhập lại mật khẩu: '
                ],
            ]);
        }
        

        $this->add([
            'type'=>'text',
            'name' => 'fullname',
            'attributes' =>[
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Họ tên: '
            ],
        ]);

        $this->add([
            'type' => 'date',
            'name' => 'birthdate',
            
            'attributes' =>[
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Ngày sinh: ',
                
            ],
        ]);

        $this->add([
            'type'=>'radio',
            'name' => 'gender',
            'attributes' =>[
                // 'style' => 'margin-left: 20px',
                'value' => 'nam',
            ],
            'options' => [
                // 'label' => 'Giới tính: ',
                'label_attributes' => [
                    'class' => 'radio-inline',
                ],
                'value_options' => [
                    'nữ' => 'Nữ',
                    'nam' => 'Nam',
                    'khác' => 'Khác'
                ]
            ],
        ]);

        $this->add([
            'type'=>'text',
            'name' => 'address',
            'attributes' =>[
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Địa chỉ: '
            ],
        ]);

        $this->add([
            'type'=>'email',
            'name' => 'email',
            'attributes' =>[
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Email: '
            ],
        ]);

        $this->add([
            'type'=>\Zend\Form\Element\Tel::class,
            'name' => 'phone',
            'attributes' =>[
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Điện thoại: '
            ],
        ]);

        $this->add([
            'type'=>'select',
            'name' => 'role',
            'attributes' =>[
                'class' => 'form-control',
                // 'multiple' => true,
                'value' => 'customer'  
            ],
            'options' => [
                'label' => 'Quyền: ',
                'value_options' => [
                    'admin' => 'Quản trị',
                    'customer' => 'Khách hàng',
                    'guest' => 'Khách',
                    'staff' => 'Nhân viên'
                ],
            ],
        ]);
        
        
        $this->add([
            'type' => 'submit',
            'name' => 'btnSubmit',
            'attributes' => [
                'class' => 'btn btn-success',
                'value' => ($this->isAdd ? 'Đăng ký': 'Cập nhật')
            ]
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
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 6,
                        'max' => 20,
                        'messages' => [
                            \Zend\Validator\StringLength::TOO_LONG => 'Username không được vượt quá %max% ký tự!',
                            \Zend\Validator\StringLength::TOO_SHORT => 'Username phải ít nhất %min% ký tự!'
                        ],
                    ],
                ],
            ]
        ]);
        if($this->isAdd){

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
                'name' => 'confirm_password',
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
                            'token' => 'password',
                            'messages' => [
                                \Zend\Validator\Identical::NOT_SAME  => "Mật khẩu không trùng nhau",
                                \Zend\Validator\Identical::MISSING_TOKEN  => "MISSING TOKEN",
                            ],
                        ]
                    ]
                ]
            ]);
        }

        $inputFilter->add([
            'name' => 'email',
            'required' => true,
            'filters' => [
                ['name'=>'StringTrim'],
                ['name'=>'StripTags'],
            ],
            'validators' => [
                [
                    'name' => 'EmailAddress',
                    'options' => [
                        'messages' => [
                            \Zend\Validator\EmailAddress::INVALID            => "Email không hợp lệ",
                            \Zend\Validator\EmailAddress::INVALID_FORMAT     => "Email không đúng định dạng",
                            \Zend\Validator\EmailAddress::INVALID_HOSTNAME   => "'%hostname%' không phải là tên host cho email",
                            \Zend\Validator\EmailAddress::INVALID_MX_RECORD  => "'%hostname%' không xuất hiện bản ghi MX hoặc A hợp lệ",
                            \Zend\Validator\EmailAddress::INVALID_SEGMENT    => "'%hostname%' không nằm trong một phân đoạn mạng có thể định tuyến. Địa chỉ email không được giải quyết từ mạng công cộng",
                            \Zend\Validator\EmailAddress::DOT_ATOM           => "'%localPart%' không thể so khớp định dạng dấu chấm",
                            \Zend\Validator\EmailAddress::QUOTED_STRING      => "'%localPart%' không thể so khớp định dạng chuỗi trích đoạn",
                            \Zend\Validator\EmailAddress::INVALID_LOCAL_PART => "'%localPart%' không hợp lệ cho email",
                            \Zend\Validator\EmailAddress::LENGTH_EXCEEDED    => "Dữ liệu nhập vượt quá độ dài cho phép",
                        ],
                    ]
                ]
            ]
        ]);

        $inputFilter->add([
            'name' => 'birthdate',
            'required' => false,
            'filters' => [
                ['name'=>'StringTrim'],
                ['name'=>'StripTags'],
            ],
            // 'validators' => [
            //     [
            //         'name' => 'date',
            //         'options' => [
            //             'format' => 'd/m/Y',
            //             'messages' => [
            //                 \Zend\Validator\Date::FALSEFORMAT  => "Không đúng định dạng '%format%'",
            //             ],
            //         ]
            //     ]
            // ]
        ]);
        
        $inputFilter->add([
            'name' => 'phone',
            'required' => false,
        ]);

        
        
    }
}

?>