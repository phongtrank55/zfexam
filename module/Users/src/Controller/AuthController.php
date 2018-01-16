<?php
namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Entity\User;
use Users\Form\LoginForm;

class AuthController extends AbstractActionController
{

    private $entityManger;
    private $userManager;
    private $authManager;
    private $authService;

    public function __construct($entityManger, $userManager, $authManager, $authService)
    {
        $this->entityManger = $entityManger;
        $this->userManager = $userManager;
        $this->authManager = $authManager;
        $this->authService = $authService;
    }

    public function loginAction()
    {
        $form = new LoginForm();
        if($this->getRequest()->isPost())
        {
            $data = $this->params()->fromPost();
            $form->setData($data);
            if($form->isValid())
            {
                echo '<pre>';
                print_r($data);
                echo '</pre>';
                die;
            }

        }
        return new ViewModel(['form' => $form]);
    }
}
?>