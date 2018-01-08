<?php
namespace Foods\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter\InputFilter;

class FoodForm extends Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setAttributes([
            'class'=>'form-horizontal',
            'id'=>'food_form',
            'enctype' => 'multipart/form-data'
        ]);
        $this->setElement();
        $this->validateForm();
    }

    private function setElement(){
        //hidden id
        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);

        //id_type
        $this->add([
            'name' => 'id_type',
            'type' => 'select',
            'options' => [ 
                'label' => 'Loại món ăn:',
                // 'empty_option' => 'Chọn loại món',
                // 'value_options' => [
                //         '0' => 'French',
                //         '1' => 'English',
                //         '2' => 'Japanese',
                //         '3' => 'Chinese',
                // ],
            ],
            'attributes'=>[
                'class' => 'form-control',
                'id' => 'id_type',
            ]
        ]);
        
        //Name
        $this->add([
            'name' => 'name',
            'type' => 'text',
            'options' => [ 
                'label' => 'Tên món:',
            ],
            'attributes'=>[
                'class' => 'form-control',
                'id' => 'name',
            ]
        ]);
        
        
        //summary
        $this->add([
            'name' => 'summary',
            'type' => 'textarea',
            'options' => [ 
                'label' => 'Mô tả ngắn:',
            ],
            'attributes'=>[
                'class' => 'form-control',
                'rows' => 3,
                'style' => 'resize:none',
                'id' => 'summary',
            ]
        ]);
        
        //detail
        $this->add([
            'name' => 'detail',
            'type' => 'textarea',
            'options' => [ 
                'label' => 'Chi tiết',
            ],
            'attributes'=>[
                'class' => 'form-control',
                'rows' => 4,
                'style' => 'resize:none',
                'id' => 'detail',
            ]
        ]);
        
        //price
        $this->add([
            'name' => 'price',
            'type' => 'text',
            'options' => [ 
                'label' => 'Đơn giá:',
            ],
            'attributes'=>[
                'class' => 'form-control',
                'id' => 'price',
            ]
        ]);
        
        //promotion
        $this->add([
            'name' => 'promotion',
            'type' => 'select',
            'options' => [ 
                'label' => 'Khuyến mãi:',
                 'empty_option' => 'Chọn loại món',
                'value_options' => [
                    'nước ngọt' => 'Nước ngọt',
                    'khăn lạnh' => 'Khăn lạnh',
                ],
            ],
            'attributes'=>[
                'class' => 'form-control',
                'multiple' => true,
                'id' => 'promotion',
            ]
        ]);

        //image
        $this->add([
            'name' => 'image',
            'type' => 'file',
            'options' => [ 
                'label' => 'Hình ảnh:',
            ],
            'attributes'=>[
               
                'id' => 'image',
            ]
        ]);
        
        //unit
        $this->add([
            'name' => 'unit',
            'type' => 'text',
            'options' => [ 
                'label' => 'Đơn vị:',
            ],
            'attributes'=>[
                'class' => 'form-control',
                'id' => 'unit',
            ]
        ]);
        
        //today
        $this->add([
            'name' => 'today',
            'type' => 'radio',
            'options' => [ 
                'label' => 'Món ăn trong ngày:',
                'class' => 'control-label',
                'value_options' => [
                    '0' => 'Không',
                    '1' => 'Có',
                ],
            ],
            'attributes'=>[
                'value' => '0',
                'id' => 'today',
                'style' => 'margin-left:20px'
            ]
        ]);

        //submit
        $this->add([
            'name'=>'submit',
           
             'type' => 'submit',
            'attributes'=>[
                'class' => 'btn btn-success',
                'id'=>'submit',
                'value'=> 'Save'
            ]
        ]);
    
    }

    private function validateForm(){
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        $inputFilter->add([
            'name' => 'name',
            // 'required' => true,
            'filters'=>[
                ['name'=>'StringTrim'],
                ['name'=>'StripTags'],
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'options' => [
                        'messages' => [
                            \Zend\Validator\NotEmpty::IS_EMPTY => "Tên món không thể để trống",
                        ],
                    ],
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'max' => 50,
                        'messages' => [
                            \Zend\Validator\StringLength::TOO_LONG => 'Tên món ăn không được vượt quá %max% ký tự!'
                        ],
                    ],
                ],

            ],
        ]);
        
        $inputFilter->add([
            'name' => 'price',
            // 'required' => true,
            'filters'=>[
                ['name'=>'StringTrim'],
            ],
            'validators' => [
                [
                
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'messages' => [
                            \Zend\Validator\NotEmpty::IS_EMPTY => "Đơn giá không thể để trống",
                        ],
                    ],
                ],
                [
                    'name' => 'Digits',
                    'options' => [
                        'messages' => [
                            \Zend\Validator\Digits::NOT_DIGITS   => "Đơn giá phải là số tự nhiên",
                            
                        ],
                    ],
                ],
                [
                    'name' => 'GreaterThan',
                    'options' => [
                        'min' => 10,
                        'inclusive' => true,
                        'messages' => [
                            \Zend\Validator\GreaterThan::NOT_GREATER_INCLUSIVE => "Đơn giá phải lớn hơn 1000 VNĐ",
                            
                        ],
                    ],
                ],

            ],
        ]);

        $inputFilter->add([
            'name'=>'image',
             'required' => false,
            
            'validators'=>[
                [
                    'name'=> 'FileMimeType', //quy định trong tệp validatorpluginManager
                    'break_chain_on_failure' => true,
                    'options'=>[
                        'mimeType'=>'image/png, image/jpg, image/jpeg',
                        'message'=>[
                            \Zend\Validator\File\MimeType::FALSE_TYPE   => "File không đúng định dạng ảnh!",
                        ],
                    ],
                ],
                [
                    'name'=> 'filesize', //quy định trong tệp validatorpluginManager
                    'options'=>[
                        'min'=>200*1024, //200kb
                        'max'=>2*1024*1024, //2mb
                        'message'=>[
                            \Zend\Validator\File\Size::TOO_BIG => "File kích thước cho phép tối thiểu là '%max%' nhưng file của bạn là '%size%'",
                            \Zend\Validator\File\Size::TOO_SMALL => "File kích thước cho phép tối đa là '%max%' nhưng file của bạn là '%size%'",
                        ],
                    ],
                ],
            
            ]
        ]);

        $inputFilter->add([
            'name' => 'promotion',
             'required' => false,
        ]);
    }
}
?>