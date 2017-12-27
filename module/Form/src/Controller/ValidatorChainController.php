<?php
namespace Form\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Validator\ValidatorChain;
use Zend\Validator\StringLength;
use Zend\Validator\Regex;

class ValidatorChainController extends AbstractActionController
{
    public function indexAction()
    {
        //password
        $validatorChain = new ValidatorChain();
        $validatorChain->attach(new StringLength([
            'min' => '6',
            'max' => '20'
        ]), true, //break khi bi loi
        1//do uu tien cang cao thi xet truoc
    );
        $validatorChain->attach(new Regex('/[A-Za-z0-9]/'), true, 2);
        $validatorChain->attach(new Regex('/[!@#$%^&*.,:]/'), true, 3);

        $value = 'abc3'; //false
        // $value = 'abc33333'; //false
        // $value = 'abc322333@43';


        if ($validatorChain->isValid($value)) {
            echo 'Dữ liệu được chấp nhận';
            
        }
        else
        {
            foreach($validatorChain->getMessages() as $message)
            {
                echo $message.'<br/>';
            }  
        }
        return false;
    }

    public function customMessageDemoAction()
    {
        //password
        $validatorChain = new ValidatorChain();
        
        $stringValidator = new StringLength([
            'min' => '6',
            'max' => '20'
        ]);
        $stringValidator->setMessages([
            StringLength::INVALID   => "Dữ liệu không hợp lệ",
            StringLength::TOO_SHORT => "Dữ liệu phải có độ dài lớn hơn %min% ký tự",
            StringLength::TOO_LONG  => "Dữ liệu phải có độ dài bé hơn %max% ký tự",
        ]);

        $validatorChain->attach($stringValidator, true,1);

        $regexValidator = new Regex('/[A-Za-z0-9]/');
        
        $regexValidator->setMessages([
            Regex::INVALID   => "Pattern không đúng",
            Regex::NOT_MATCH => "Dữ liệu không hợp lệ với mẫu '%pattern%'",
            Regex::ERROROUS  => "Lỗi nội bộ khi dùng '%pattern%'",
        ]);
        $validatorChain->attach($regexValidator, true, 2);
        $regexValidator->setPattern('/[!@#$%^&*.,:]/');
        $validatorChain->attach($regexValidator, true, 3);
        

        $value = 'abc3'; //false
        // $value = 'abc33333'; //false
        // $value = 'abc322333@43';


        if ($validatorChain->isValid($value)) {
            echo 'Dữ liệu được chấp nhận';
            
        }
        else
        {
            foreach($validatorChain->getMessages() as $message)
            {
                echo $message.'<br/>';
            }  
        }
        return false;
    }
}

?>