<?php
namespace Form\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class FormElement extends Form
{
    public function __construct()
    {
        parent::__construct();
        //$this->setAttribute('method', 'GET');
        // input
        $name = new Element('fullname');
        $name->setLabel('Ten cua ban:');
        $name->setLabelAttributes([
            'id'=>'fullname',
            'class'=>'control-label'
        ]);
        $name->setAttributes([
            'type'=>'text',
            'class'=>'form-control',
            'id'=>'fullname',
            'placeholder'=>'Nhap ho ten'
        ]);
        
        //hidden
        $hidden = new Element("hidden_input");
        $hidden->setAttributes([
            'type'=>'hidden',
            'value'=>'Phong Trần'
        ]);
        
        $age = new Element\Number("input_number");
        
        $age->setLabel('Tuoi:')
            ->setLabelAttributes(['class'=> 'control-label'])
            ->setAttributes([
            'min'=>10,
            'max'=>85,
            'class' => 'form-control',
            'id' => 'age',
            'value'=>20
        ]);
        
    // $age = new Element("input_number");
        // $age->setLabel('Tuoi: ');
        // $age->setLabelAttributes([
        //     'class'=>'form-label'
        // ]);

        // $age->setAttributes([
        //     'type'=>'number',
        //     'min'=>10,
        //     'max'=>85,
        //     'class' => 'form-control',
        //     'id' => 'age',
        //     'value'=>20    
        // ]);
        
        // email
        $email = new Element\Email('my_email');
        $email->setLabel('Email:')
            ->setLabelAttributes(['class'=>'control-label'])
            ->setAttribute('class', 'form-control')
            ->setAttributes([
                'id'=>'email',
                'require' =>true,
                'placeholder'=>'nhap Email'
            ]);

        // password
        $password = new Element\Password('my_password');
        $password->setLabel('Mat khau:')
            ->setLabelAttributes(['class'=>'control-label'])
            ->setAttributes([
                'id'=>'password',
                'class'=>'form-control',
                'require' =>true,
                'placeholder'=>'nhap mat khau',
                'minlength'=>6,
                'maxlength'=>30
            ]);
        // Radio
        $gender = new Element\Radio('my_radio');
        $gender->setLabel('Gioi tinh:')
            ->setAttributes([
                'id'=>'gender',
                'value'=>'nam',
                'style'=>'margin-left: 20px'
            ]);
        $gender->setValueOptions([
            'nam'=>'Nam',
            'nu'=>'Nữ',
            'other'=>'Other',
            
        ]);
            // select
        $select = new Element\Select('language');
        $select->setLabel('Which is your mother tongue?')
            ->setAttributes(['class'=>'form-control',
                            'id'=>'language',
                            //'multiple' =>true
                            ])
            ->setValueOptions([
            'empty_option' => 'Please choose your language',
            'european' =>[
            'label' => 'European languages',
            'options' => [
               '0' => 'French',
               '1' => 'Italian',
            ],
        ],
         'asian' => [
            'label' => 'Asian languages',
            'options' => [
               '2' => 'Japanese',
               '3' => 'Chinese',
            ],
         ],
         
        ]);

        //TextArea
        $textarea = new Element\Textarea("message");
        
        $textarea->setLabel('Nhập nội dung:')
            ->setLabelAttributes(['class'=> 'control-label'])
            ->setAttributes([
            'class' => 'form-control',
            'id' => 'message',
            'rows'=> 3,
            'style' => 'resize:none'
        ]);
        
        //File
        $file = new Element\File("my_file");
        $file->setLabel('Chon file:')
            ->setAttributes([
                'id' => 'file',
                'multiple'=>true,
            ]);
        //checkbox

        $checkbox = new Element\Checkbox("my_checkbox");
        $checkbox->setLabel('Remember me')
        ->setUseHiddenElement(true)
        ->setCheckedValue("yes")
        ->setUncheckedValue("no")
            ->setAttributes([
                'id' => 'remember',
            ]);


        //multicheckbox

        $multicheckbox = new Element\MultiCheckbox("my_multicheckbox");
        $multicheckbox->setLabel('Sở thích:')
            ->setAttributes([
                'id' => 'sothich',
                'checked' => true,
                'value'=>[0, 1]
            ])
            ->setValueOptions([
                0=>'Bóng đá', 
                1=>'Bóng rổ',
                2=>'Bơi'
            ]);

        
        //add into form
        $this->add($name);
        $this->add($hidden);
        $this->add($age);
        $this->add($email);
        $this->add($password);
        $this->add($gender);
        $this->add($select);
        $this->add($textarea);
        $this->add($file);
        $this->add($checkbox);
        $this->add($multicheckbox);

        //color
        $this->add([
            'name'=>'my_color',
             // 'type'=>'Element\Color::class',
             'type' => 'color',
            'options'=>[
                'label'=>'Chọn màu:',
            ],
            'attributes'=>[
                'value' => '#fffhh',
                'id'=>'mau'
            ]
        ]);

        //date
        $this->add([
            'name'=>'my_date',
             // 'type'=>'Element\Date::class',
             'type' => 'date',
            'options'=>[
                'label'=>'Ngày sinh:',
            ],
            'attributes'=>[
                'class' => 'form-control',
                'id'=>'date'
            ]
        ]);
        //range
        $this->add([
            'name'=>'my_range',
             // 'type'=>'Element\Range::class',
             'type' => 'range',
            'options'=>[
                'label'=>'Chọn giá trị',
            ],
            'attributes'=>[
                'class' => 'form-control',
                'id'=>'range',
                'min'=>5,
                'max'=>20,
                'value'=>16
            ]
        ]);
        
        //button reset
        $this->add([
            'name'=>'my_reset',
             // 'type'=>'Element\Button::class',
             'type' => 'button',
             'options'=>[
                'label' =>'Nút reset'
             ],
            'attributes'=>[
                'class' => 'btn btn-primary',
                'id'=>'reset',
                'type'=>'reset'
            ]
            
        ]);
        
        //button submit
        $this->add([
            'name'=>'my_submit',
             // 'type'=>'Element\Submit::class',
             'type' => 'submit',
            'attributes'=>[
                'class' => 'btn btn-success',
                'id'=>'submit',
                'value'=> 'Send'
            ]
        ]);
        // $this->add([
        //     'name'=>'my_submit',
        //      // 'type'=>'Element\Button::class',
        //      'type' => 'button',
        //      'options'=>[
        //         'label' =>'OK'
        //      ],
        //     'attributes'=>[
        //         'class' => 'btn btn-success',
        //         'id'=>'submit',
        //         'type'=>'submit'
        //     ]
        // ]);
            
        //captcha image
        $this->add([
            'name'=>'my_captcha',
             // 'type'=>'Element\Captcha::class',
             'type' => 'captcha',
             'options'=>[
                 'label'=>'Human check:',
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
                     'expiration'=>120//2 minutes
                 ],
            ],
            'attributes'=>[
                'id'=>'captcha',
            ]

        ]);
    }
}
?>