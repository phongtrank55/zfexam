<?php
namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Entity\User;
use Users\Form\UserForm;

class UserController extends AbstractActionController
{

    private $entityManger;
    private $userManager;

    public function __construct($entityManger, $userManager)
    {
        $this->entityManger = $entityManger;
        $this->userManager = $userManager;
    }
 
    public function indexAction()
    {
        $users =  $this->entityManger->getRepository(User::class)->findAll();
        // $users =  $this->entityManger->getResponsitory(User::class)->findBy([]);

        return new ViewModel(['users' => $users]);
    }

    public function registerAction()
    {
        $form = new UserForm();
        $request = $this->getRequest();
        if($request->isPost())
        {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if($form->isValid())
            {
                $data =$form->getData();
                echo '<pre>';
                print_r($data);
                echo '</pre>';
            }
            // else{
            //     echo '<pre>';
            //     print_r($form->getMessages());
            //     echo '</pre>';
            // }
        }

        return new ViewModel(['form' => $form]);
    }
}

?>