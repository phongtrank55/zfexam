<?php
namespace Form\Form;
use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter;

class UploadFile extends Form
{
    public function __construct()
    {
        parent::__construct();
        $this->add([
            'name'=>'file-upload',
            'type'=>'file',
            'attributes'=>[
                'multiple'=>true,
            ],
            'options'=>[
                'label' => 'chọn file'
            ]
            
        ]);


        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes'=>[
                'value'=> 'Upload', 
                'class' => 'btn btn-primary',
                'id' => 'submit',
                
            ]
        ]);

        $this->uploadInputFilter();
    }

    private function uploadInputFilter()
    {
        // $fileUpload = new InputFilter('file-upload');
        // $fileUpload->setRequired(true);
        $fileUpload = new \Zend\InputFilter\InputFilter();
        $this->setInputFilter($fileUpload);

        $fileUpload->add([
            'name'=>'file-upload',
            'required'=>true,
            'validators'=>[
                [
                    'name'=> 'filesize', //quy định trong tệp validatorpluginManager
                    'options'=>[
                        'max'=>200*1024, //200kb
                        'message'=>[
                            \Zend\Validator\File\Size::TOO_BIG   => "File kích thước cho phép tối đa là '%max%' nhưng file của bạn là '%size%'",
                        ],
                    ],
                ],
                [
                    'name'=> 'FileMimeType', ////quy định trong tệp validatorpluginManager
                    'options'=>[
                        'mimeType'=>['image/png, image/pdf, image/jpeg'],
                        'message'=>[
                            \Zend\Validator\File\MimeType::FALSE_TYPE   => "File không đúng định dạng ảnh!",
                        ],
                    ],
                ],
            ]

        ]);
        
    }

}

?>