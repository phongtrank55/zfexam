<?php
namespace Form\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Model\View\ViewModel;
use Zend\Validator;
//use Zend\Validator\ValidatorInterface;
use Zend\Validator\StringLength;
use Form\Form\FormElement;

class ValidatorController extends AbstractActionController
{
    public function stringAction()
    {
        $validator = new Validator\StringLength(['min'=>6, 'max'=>10]);
        $validator->setMessages([
            Validator\StringLength::INVALID   => "Kiểu dữ liệu không được phép",
            Validator\StringLength::TOO_SHORT => "Giá tri %value% quá ngắn, yêu cầu ít nhất %min% ký tự!",
            Validator\StringLength::TOO_LONG  => "Giá tri %value% quá dài, yêu cầu tối đa %max% ký tự!",
        ]);
        $var = "testcase3srr";
        if($validator->isValid($var))
        {
            echo $var;
        }
        else 
        {
            foreach($validator->getMessages() as $message)
            {
                echo $message.'<br />';
            }
        }
        return false;
    }

    public function  numberAction()
    {
        $validator = new Validator\Between([
            'min'=>5, 'max'=>10, 'inclusive'=>true // neu false la lay tu 6->9
        ]);

        $var = "5";
        if($validator->isValid($var))
        {
            echo $var;
        }
        else 
        {
            foreach($validator->getMessages() as $message)
            {
                echo $message.'<br />';
            }
        }
        return false;
    }

    public function dateAction()
    {
        $validator = new Validator\Date([
            'format'=>'d-m-Y'
        ]);

        // $var = "2/10/1895";
        // $var = "2-10-1895";//true
        // $var = "2-10-95";//true
        $var = '1996-12-7';
        if($validator->isValid($var))
        {
            echo $var;
        }
        else 
        {
            foreach($validator->getMessages() as $message)
            {
                echo $message.'<br />';
            }
        }
        return false;
    }

    public function emailAction()
    {
        $validator = new Validator\EmailAddress([
            
        ]);
        
        // $var = "phongtran@gmail";//false
        $var = "phongtran@gmil.com";//false
        
        if($validator->isValid($var))
        {
            echo $var;
        }
        else 
        {
            foreach($validator->getMessages() as $message)
            {
                echo $message.'<br />';
            }
        }
        return false;
    }

    public function digitsAction()
    {
        $validator = new Validator\Digits();

        // $var = 1;//true
        // $var = 1.2;//false
        // $var = "1";// true
        // $var = "abc"; //false
        // $var = "334444444444444444444444444444666666666666666666666666666666666666664444444444"; //true
        $var = -34;//false
        if($validator->isValid($var))
        {
            echo $var;
        }
        else 
        {
            foreach($validator->getMessages() as $message)
            {
                echo $message.'<br />';
            }
        }
        return false;
    }

    // GreaterThan > || >=
    public function greaterThanAction()
    {
        $validator = new Validator\GreaterThan([
            'min' => 10,
            'inclusive' => true //>=
        ]);

        $var = 6;//false

        if($validator->isValid($var))
        {
            echo $var;
        }
        else 
        {
            foreach($validator->getMessages() as $message)
            {
                echo $message.'<br />';
            }
        }
        return false;
    }

    // lessThan < || <=
    public function lessThanAction()
    {
        $validator = new Validator\LessThan([
            'max' => 10,
            'inclusive' => true //<=
        ]);

        $var = 6;//true

        if($validator->isValid($var))
        {
            echo $var;
        }
        else 
        {
            foreach($validator->getMessages() as $message)
            {
                echo $message.'<br />';
            }
        }
        return false;
    }

    
    public function regexAction()
    {
        // $validator = new Validator\Regex('/^zend/');
        $validator = new Validator\Regex(['pattern'=> '/^zend/']);

        // $var = 'zendfw';//true
        $var = 'avczendfw';//false

        if($validator->isValid($var))
        {
            echo $var;
        }
        else 
        {
            foreach($validator->getMessages() as $message)
            {
                echo $message.'<br />';
            }
        }
        return false;
    }

    
    public function notEmptyAction()
    {
        // $validator = new Validator\NotEmpty(Validator\NotEmpty::INTEGER);
        //  $var = 0;//FALSE
        //  $var = "0"; //true

        // $validator = new Validator\NotEmpty(Validator\NotEmpty::STRING);
        //  $var = 0;//true
        //  $var = "0"; //true
        // $var = ''; //false
    
        // $validator = new Validator\NotEmpty(Validator\NotEmpty::ZERO);
        //  $var = 0;//true
        //  $var = "0"; //false
        // $var = ''; //true
    
        // $validator = new Validator\NotEmpty(Validator\NotEmpty::ZERO | Validator\NotEmpty::INTEGER);
        //  $var = 0;//false
        //  $var = "0"; //false
        // $var = ''; //true

        // $validator = new Validator\NotEmpty(Validator\NotEmpty::ZERO, Validator\NotEmpty::INTEGER);
        // $var = 0;//true
        // $var = "0"; //false"
        // $var = ''; //true"

         $validator = new Validator\NotEmpty();
         $validator->setType(['integer', 'zero']);
        // $var = 0;//true
        // $var = "0"; //false"
         $var = ''; //true"

        if($validator->isValid($var))
        {
            echo $var;
        }
        else 
        {
            foreach($validator->getMessages() as $message)
            {
                echo $message.'<br />';
            }
        }
        return false;
    }
    public function inArrayAction()
    {
        // $validator = new Validator\InArray([
        //     'haystack' => ['val1', 'val2', 100, '5', 'val3'],
        //     // 'strict' => 1,// so sánh cả data type và value
        //     // 'strict' => -1,// so sánh value;  khi so sánh vs 0 => true
        //     'strict' => 0// khi so sánh vs 0 => false
        // ]);

        // // $var = 6;//false
        // // $var = 5;
        // $var =0;

        $validator = new Validator\InArray([
            'haystack' => [
                'key1' => ['val1', 'val2', 100, '5', 'val3'],
                'key2' => [1, 2, 7, 4]
            ],
            // 'strict' => 1,// so sánh cả data type và value
            // 'strict' => -1,// so sánh value;  khi so sánh vs 0 => true
            'strict' => 0, // khi so sánh vs 0 => false
            'recursive' => true // tìm đệ quy
        ]);

        // $var = 6;//false
         $var = 5;
        

        if($validator->isValid($var))
        {
            echo $var;
        }
        else 
        {
            foreach($validator->getMessages() as $message)
            {
                echo $message.'<br />';
            }
        }
        return false;
    }

    public function fileExistsAction()
    {
        $validator = new Validator\File\Exists();
        // $file = APPLICATION_PATH.'/public/files/check.jpg'; //false
        $file = APPLICATION_PATH.'/public/files/checkfileEXISTS.txt'; //true
        
        if($validator->isValid($file))
        {
            echo $file.' ton tai';
        }
        else
        {
            foreach($validator->getMessages() as $message)
            {
                echo $message.'<br />';
            }
        }
        return false;
    }
    
    public function fileNotExistsAction()
    {
        $validator = new Validator\File\NotExists();
        // $file = APPLICATION_PATH.'/public/files/check.jpg'; //true
        $file = APPLICATION_PATH.'/public/files/checkfileEXISTS.txt'; //false
        
        if($validator->isValid($file))
        {
            echo $file.' ton tai';
        }
        else
        {
            foreach($validator->getMessages() as $message)
            {
                echo $message.'<br />';
            }
        }
        return false;
    }
    
    public function fileExtensionAction()
    {
        $validator = new Validator\File\Extension([
            'case' => true,//phan biet hoa thuong
            'extension'=>['php', 'png', 'txt']
        ]);
        $file = APPLICATION_PATH.'/public/files/check.jpg'; //false
        // $file = APPLICATION_PATH.'/public/files/checkfileEXISTS.txt'; //true    
        // $file = APPLICATION_PATH.'/public/files/checkfileEXI.txt'; //false
        
        if($validator->isValid($file))
        {
            echo $file.' duoc phep chon';
        }
        else
        {
            foreach($validator->getMessages() as $message)
            {
                echo $message.'<br />';
            }
        }
        return false;
    }
    
    
    public function fileSizeAction()
    {
        $validator = new Validator\File\Size([
            'min'=>1024, //1kb
            'max'=>10240, //10kb
        ]);
        // $file = APPLICATION_PATH.'/public/files/check.jpg'; //false
        // $file = APPLICATION_PATH.'/public/files/checkfileEXISTS.txt'; //false// be qua
        $file = APPLICATION_PATH.'/public/files/anh.png'; //false// lon
        
        if($validator->isValid($file))
        {
            echo $file.' duoc phep chon';
        }
        else
        {
            foreach($validator->getMessages() as $message)
            {
                echo $message.'<br />';
            }
        }
        return false;
    }
    
    public function imageSizeAction()
    {
        $validator = new Validator\File\ImageSize([
            'minwidth'=>200, 
            'maxwidth'=>1024,
            'minheight'=>400,
            'maxheight'=>1000,
        ]);
        // $file = APPLICATION_PATH.'/public/files/check.jpg'; 
        $file = APPLICATION_PATH.'/public/files/anh.png'; 
        
        if($validator->isValid($file))
        {
            echo $file.' duoc phep chon';
        }
        else
        {
            foreach($validator->getMessages() as $message)
            {
                echo $message.'<br />';
            }
        }
        return false;
    }
    
    public function isImageAction ()
    {
        $validator = new Validator\File\IsImage();
        $file = APPLICATION_PATH.'/public/files/checkfileEXISTS.txt'; //false
        // $file = APPLICATION_PATH.'/public/files/anh.png'; //true
        
        if($validator->isValid($file))
        {
            echo $file.' duoc phep chon';
        }
        else
        {
            foreach($validator->getMessages() as $message)
            {
                echo $message.'<br />';
            }
        }
        return false;
    }
    
    public function isCompressedAction ()
    {
        $validator = new Validator\File\IsCompressed();
        $file = APPLICATION_PATH.'/public/files/checkfileEXISTS.txt'; //false
        // $file = APPLICATION_PATH.'/public/files/anh.png'; //false
        
        if($validator->isValid($file))
        {
            echo $file.' duoc phep chon';
        }
        else
        {
            foreach($validator->getMessages() as $message)
            {
                echo $message.'<br />';
            }
        }
        return false;
    }
    
    public function wordCountAction ()
    {
        $validator = new Validator\File\WordCount([
            'min'=>5,
            'max'=>10,
        ]);
        $file = APPLICATION_PATH.'/public/files/checkfileEXISTS.txt'; //false
        // $file = APPLICATION_PATH.'/public/files/anh.png'; //false//vi nhieu
        
        if($validator->isValid($file))
        {
            echo $file.' duoc phep chon';
        }
        else
        {
            foreach($validator->getMessages() as $message)
            {
                echo $message.'<br />';
            }
        }
        return false;
    }
    
    public function passwordStrengthAction ()
    {
        $validator = new Validator\PasswordStrength();// custom validator
        
        $val = "12345333 ";

        if($validator->isValid($val))
        {
            echo 'Mat khau hop le';
        }
        else
        {
            foreach($validator->getMessages() as $message)
            {
                echo $message.'<br />';
            }
        }
        return false;
    }
    
}

?>