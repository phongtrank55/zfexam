<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Started\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController
{
    // public function loginAction()
    // {

    //     $checkMethod = $this->getRequest();
    //     if($checkMethod->isGet())
    //     {
    //         $action = $this->params()->fromRoute('action', 'abc');
    //         $id = $this->params()->fromRoute('id', '0');
    //         echo $action.'<br>';
    //         echo $id.'<br>';
    //         echo 'Using Get';
    //     }
    //     else if($checkMethod->isPost())
    //     {
    //         $var = $this->params()->fromPost('name', 'ABVC');
    //         echo $var.'<br>';
    //         echo 'Using Post';
    //     }        
    //     else if($checkMethod->isXmlHttpRequest()){
    //         echo 'Using AJax';
    //     }
    //     echo '<br />';
    //     echo $checkMethod->getMethod();
    //     echo '<br />';
    //     echo $checkMethod->getUriString();
    //     //  echo 'login';
    //     return false;
        
    // }

    public function loginAction()
    {
        $checkMethod = $this->getRequest();
        if($checkMethod->isGet())
        {
            $action = $this->params()->fromRoute('action', 'abc');
            $id = $this->params()->fromRoute('id', '0');
            
        }else{
            
        }

        if($id<=0)
        {
            // $this->getResponse()->setStatusCode(404);
            // return;
            throw new \Exception("id khong tim thay");
        }
        return new ViewModel([
            'id'=>$id,
            'action'=>$action
        ]);
    }

    public function login3Action(){
        $view = new ViewModel([
            'message'=>'Hello login3',
            'name'=>'pt'

        ]);
        $view->setTemplate('started/index/login3');
        return $view;
    }
    public function logoutAction()
    {
        echo 'logout';
        return false;
    }

}
