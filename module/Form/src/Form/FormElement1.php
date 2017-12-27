<?php
namespace Form\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class FormElement1 extends Form
{
    public function __construct()
    {
        parent::__construct();
        $email = new Element("email");//
        $email->setLabel("Email");
        $email->setLabelAttributes([
            'class'=>'form-label'
        ]);
        $email->setAttributes([
            'class'=>'form-control',
            'id'=>'mail',
            'placeholder'=>'Nhap dia chi email',
            'type'=>'email'
        ]);

        
        $this->add($email);
    }
}

?>