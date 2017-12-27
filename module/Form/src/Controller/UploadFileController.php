<?php
namespace Form\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Form\Form\UploadFile;
use Zend\File\Transfer\Adapter\Http;
use Zend\Filter\File\Rename;

class UploadFileController extends AbstractActionController
{
    public function indexAction()
    {
        $form = new UploadFile();
        $request = $this->getRequest();
        if($request->isPost())
        {
            $files = $request->getFiles()->toArray();
            // print_r($files);
            $fileUpload = new Http();
            // $fileInfo = $fileUpload->getFileInfo();
            // // print_r($fileInfo);
            
            // echo 'Name:'.$fileUpload->getFileName().'<br/>';
            // echo 'Size:'.$fileUpload->getFileSize().'<br/>';
            // echo 'Type:'.$fileUpload->getMimeType().'<br/>';
            // $fileUpload->setDestination(FILE_PATH.'upload');
            // $fileUpload->receive();
            
            //use Filter

            $form->setData($files);

            if($form->isValid($files)){
                $fileFilter = new Rename([
                    'target'=> FILE_PATH.'upload/'.$files['file-upload']['name'],
                    'randomize'=>true //tao duoi ngau nhien
                ]);
                $fileFilter->filter($files['file-upload']);
                echo 'Thành công';
            }
            else
            {
                print_r($files['file-upload']['type']);

                foreach($form->getMessages() as $message)
                {
                    echo '<br/>';
                    print_r($message);
                }
            }
        }


        return new ViewModel(['form' => $form]);
       
    }
    public function uploadMultipleAction()
    {
        $form = new UploadFile();
        $request = $this->getRequest();
        if($request->isPost())
        {
            $files = $request->getFiles()->toArray();
            
            $form->setData($files);

            if($form->isValid($files)){
                $data= $form->getData();
               
                foreach($data['file-upload'] as $image){
                
                    $fileFilter = new Rename([
                        'target'=> FILE_PATH.'upload/'.$image['name'],
                        'randomize'=>true //tao duoi ngau nhien
                    ]);
                    $fileFilter->filter($image);
                    }
                echo 'Thành công';
            }
            else
            {


                foreach($form->getMessages() as $message)
                {
                    echo '<br/>';
                    print_r($message);
                }
            }
        }


        return (new ViewModel(['form' => $form]))->setTemplate('form/upload-file/index');
       
    }
}

?>