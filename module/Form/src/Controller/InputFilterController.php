<?php
namespace Form\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Form\Form\Login;

class InputFilterController extends AbstractActionController
{
    public function indexAction()
    {
        $form = new Login();
        if($this->getRequest()->isPost())
        {
            $data =  $this->params()->fromPost();
            $form->setData($data);

            if($form->isValid()){
                $data = $form->getData();
                print_r($data);
            }
            else{
                // foreach($form->getMessages() as $message)
                // {
                //     print_r($message);
                //     echo '<br />';
                // }
            }
        }
        return (new ViewModel(['form' => $form]))
                ->setTemplate('form/input-filter/login');
    }
}

?>