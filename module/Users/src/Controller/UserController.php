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

        echo '<pre>';
        print_r($users);
        echo '</pre>';
        return false;
        //return new ViewModel();
    }
}

?>