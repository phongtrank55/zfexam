<?php
namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Users\Form\UserForm;

class UserController extends AbstractActionController
{
    public function indexAction()
    {
        
        return new ViewModel();
    }
}

?>