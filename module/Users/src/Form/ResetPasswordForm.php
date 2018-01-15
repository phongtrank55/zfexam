<?php
namespace Users\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter\InputFilter;


class ResetPasswordForm extends Form
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
                'name' => 'csrf',
                'type' => 'csrf',
                'options' => [
                    'csrf_options' => [
                        'timeout' => 180
                    ]
                ]
            ]);

            $this->add([
                'name' => 'captcha_image',
                'type' => 'captcha',
                'options'=>[
                    'label'=>'Nhập mã:',
                    'captcha' =>[
                        'class'=>'Image',
                        'imgDir'=>'public/img/captcha',//noi luu anh captcha
                        'imgUrl' => '../img/captcha',//noi trinh duyet lay anh de hien thi
                        'suffix' => '.png',
                        'font'=> APPLICATION_PATH.'/data/font/Pangolin-Regular.ttf',
                        'fsize'=>50,
                        'width'=>400,
                        'height'=>150,
                        'dotNoiseLevel'=>200,
                        'lineNoiseLevel'=>4,
                        'expiration'=>180, //2 minutes
                        'messages' => [
                            \Zend\Captcha\AbstractWord::MISSING_VALUE => 'Bạn chưa nhập captcha',
                            \Zend\Captcha\AbstractWord::MISSING_ID    => 'Trường id củ captcha đã mất',
                            \Zend\Captcha\AbstractWord::BAD_CAPTCHA   => 'Bạn đã nhập sai captcha',
                        ]
                    ],
               ],
               'attributes' => [
                   'class' => 'form-control'
               ]
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
        $this->add([
            'type'=>'text',
            'name' => 'email',
            'attributes' =>[
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Nhập email của bạn: '
            ],
        ]);
        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => [
                'class' => 'btn btn-success',
                'value' => 'Gửi'
            ]
        ]);
    }

    public function validateForm()
    {
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        $inputFilter->add([
            'name' => 'email',
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
                            \Zend\Validator\NotEmpty::IS_EMPTY => "Email không thể để trống",
                        ],
                    ],
                ],   

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

        
        
    }
}

?>