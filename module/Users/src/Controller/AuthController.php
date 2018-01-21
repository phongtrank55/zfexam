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
                
                $result = $this->authManager->login($data['username'], $data['password'], $data['remember']);
                if($result->getCode()==1)
                {
                    return $this->redirect()->toRoute('user');
                }
                else
                {
                    $this->flashMessenger()->addErrorMessage($result->getMessages());
                    return $this->redirect()->toRoute('login');

                }
            }

        }
        return new ViewModel(['form' => $form]);
    }

    public function logoutAction()
    {
        $this->authManager->logout();
        return $this->redirect()->toRoute('login');
    }
}
?>