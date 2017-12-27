<?php
namespace Form\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter;

class Login extends Form
{
    public function __construct()
    {
        parent::__construct();
        $this->loginForm();
        $this->loginInputFilter();
    }

    private function loginForm()
    {
        $this->add([
            'name' => 'email',
            'type' => 'email',
            'options' => [ 
                'label' => 'Email:',
                'label_attributes' =>[
                    'class' => 'control-label col-md-3'
                ]
            ],
            'attributes'=>[
                'class' => 'form-control',
                'id' => 'email',
                'placeholder' => 'example@mail.com'
            ]
        ]);

        $this->add([
            'name' => 'password',
            'type' => 'password',
            'options' => [ 
                'label' => 'Mật khẩu:',
                'label_attributes' =>[
                    'class' => 'control-label col-md-3'
                ]
            ],
            'attributes'=>[
                'class' => 'form-control',
                'id' => 'password',
                'placeholder' => 'pass30Rd'
            ]
        ]);

        $this->add([
            'name' => 'remember',
            'type' => 'checkbox',
            
            'attributes'=>[
                'value'=>1, 
                'required'=> false,
                'id' => 'remember',
                
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes'=>[
                'value'=> 'Đăng nhập', 
                'class' => 'btn btn-primary',
                'id' => 'submit',
                
            ]
        ]);
    }

    private function loginInputFilter()
    {
        $inputFilter = new InputFilter\InputFilter();
        $this->setInputFilter($inputFilter);
        $inputFilter->add([
            'name' => 'email',
            'required' => true,
            'filters' => [
                //trim //tolower//toupper//newline
                ['name' => 'StringToLower'],
                ['name' => 'StringTrim'],
            ],
            'validators'=>[
                [
                    'name' => 'EmailAddress',
                    'options' => [
                        'messages'=>[
                            \Zend\Validator\EmailAddress::INVALID            => "Email không hợp lệ",
                            \Zend\Validator\EmailAddress::INVALID_FORMAT     => "Email không đúng định dạng",
                            \Zend\Validator\EmailAddress::INVALID_HOSTNAME   => "'%hostname%' không phải là tên host cho email",
                            \Zend\Validator\EmailAddress::INVALID_MX_RECORD  => "'%hostname%' không xuất hiện bản ghi MX hoặc A hợp lệ",
                            \Zend\Validator\EmailAddress::INVALID_SEGMENT    => "'%hostname%' không nằm trong một phân đoạn mạng có thể định tuyến. Địa chỉ email không được giải quyết từ mạng công cộng",
                            \Zend\Validator\EmailAddress::DOT_ATOM           => "'%localPart%' không thể so khớp định dạng dấu chấm",
                            \Zend\Validator\EmailAddress::QUOTED_STRING      => "'%localPart%' không thể so khớp định dạng chuỗi trích đoạn",
                            \Zend\Validator\EmailAddress::INVALID_LOCAL_PART => "'%localPart%' không hợp lệ cho email",
                            \Zend\Validator\EmailAddress::LENGTH_EXCEEDED    => "Dữ liệu nhập vượt quá độ dài cho phép",
                        ]
                    ]
                ]
            ]
        ]);

        $inputFilter->add([
            'name' => 'password',
            'required' => true,
            'filters' => [
                //trim //tolower//toupper//newline
                ['name' => 'StringToLower'],
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name'=>'StripNewlines']
            ],
            'validators'=>[
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min'=> 7,
                        'max'=> 20,
                        'messages'=>[
                           \Zend\Validator\StringLength::INVALID   => "Mật khẩu không được phép",
                            \Zend\Validator\StringLength::TOO_SHORT => "Mật khẩu quá ngắn, yêu cầu ít nhất %min% ký tự!",
                            \Zend\Validator\StringLength::TOO_LONG  => "Mật khẩu quá dài, yêu cầu tối đa %max% ký tự!",
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
                ],
            ]
        ]);
    }
}

?>