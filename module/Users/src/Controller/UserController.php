<?php
namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Entity\User;
use Users\Form\UserForm;
use Users\Form\ChangePasswordForm;
use Users\Form\ResetPasswordForm;

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
                // $data =$form->getData();
                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                // die;
                try{
                    $user = $this->userManager->addUser($data);

                    // echo '<pre>';
                    // print_r($user);
                    // echo '</pre>';
                //    die;
                    $this->flashMessenger()->addSuccessMessage("Thêm thành công!");
                    return $this->redirect()->toRoute('user');
                }
                catch(\Exception $ex)
                {
                    $this->flashMessenger()->addErrorMessage($ex->getMessage());
                }
            }
            // else{
            //     echo '<pre>';
            //     print_r($form->getMessages());
            //     echo '</pre>';
            // }
        }

        return new ViewModel(['form' => $form]);
    }

    public function editAction()
    {
        $form = new UserForm(false);

        $id = (int)$this->params()->fromQuery('id', 0);
        if($id <= 0)
            return $this->getResponse()->setStatusCode('404');
        
        $user = $this->entityManger->getRepository(User::class)->find($id);
        if(!$user)
            return $this->getResponse()->setStatusCode('404');
        
        if($this->getRequest()->isGet())
        {
            $data = [
                'id' => $user->getId(),
                'username' => $user->getUserName(),
                'fullname' => $user->getFullname(),
                'email' => $user->getEmail(),
                'address' => $user->getAddress(),
                'birthdate' => $user->getBirthDate(),
                'gender' => $user->getGender(),
                'phone' => $user->getPhone(),
                'role'=> $user->getRole()
            ];
            $form->setData($data);
        
        }
        else{
            $data = $this->params()->fromPost();
            $form->setData($data);
            if($form->isValid())
            {
                $data = $form->getData();
                try{
                    $this->userManager->editUser($user, $data);
                    $this->flashMessenger()->addSuccessMessage("Cập nhật thành công!");
                    return $this->redirect()->toRoute('user');
                }
                catch(\Exception $ex)
                {
                    $this->flashMessenger()->addErrorMessage($ex->getMessage());
                }
            }
        }
        
        return new ViewModel(['form' => $form]);
    }

    public function deleteAction()
    {

        $id = (int)$this->params()->fromQuery('id', 0);
        if($id <= 0)
            return $this->getResponse()->setStatusCode('404');
        
        $user = $this->entityManger->getRepository(User::class)->find($id);
        if(!$user)
            return $this->getResponse()->setStatusCode('404');

        if($this->getRequest()->isPost()){
            $btn=$this->getRequest()->getPost('delete', 'No');
            if($btn=='Yes')
            {
                $this->userManager->removeUser($user);
                $this->flashMessenger()->addSuccessMessage("Đã xóa thành công!");
                return $this->redirect()->toRoute('user');
            }
        }
        return new ViewModel(['user' => $user]);
    }

    public function changePasswordAction()
    {
        $id = (int)$this->params()->fromQuery('id', 0);
        if($id <= 0)
            return $this->getResponse()->setStatusCode('404');
        
        $user = $this->entityManger->getRepository(User::class)->find($id);
        if(!$user)
            return $this->getResponse()->setStatusCode('404');

        $form = new ChangePasswordForm();
        if($this->getRequest()->isPost())
        {
            $data = $this->params()->fromPost();
            $form->setData($data);
            if($form->isValid())
            {
                $data = $form->getData();
                try
                {
                    $this->userManager->changePassword($user, $data);
                    $this->flashMessenger()->addSuccessMessage("Đã thay đổi mật khẩu thành công!");
                    return $this->redirect()->toRoute('user');
                }
                catch(\Exception $e)
                {
                    $this->flashMessenger()->addErrorMessage($e->getMessage());
                }

            }

        }

        return new ViewModel(['form' => $form]);
    }

    public function resetPasswordAction(){
        $form = new ResetPasswordForm();

        if($this->getRequest()->isPost())
        {
            $data = $this->params()->fromPost();
            $form->setData($data);
            if($form->isValid())
            {
                $data = $form->getData();
                $user = $this->entityManger->getRepository(User::class)->findOneByEmail($data['email']);
                if($user!==null)
                {
                    $this->userManager->createTokenPasswordReset($user);
                    $this->flashMessenger()->addSuccessMessage("Kiểm tra email để reset mật khẩu!");
             
                }
                else
                    $this->flashMessenger()->addErrorMessage("Email không tồn tại!");

                return $this->redirect()->toRoute('user', ['action' => 'resetPassword']);
            }
            
        }

        return new ViewModel(['form' => $form]);
    }

}

?>