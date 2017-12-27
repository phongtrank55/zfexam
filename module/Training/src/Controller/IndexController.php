<?php

namespace Training\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
class IndexController extends  AbstractActionController{
    public function indexAction()
    {
        //disable view
        //method 1
        //return false;

        //disable layout
        //return (new ViewModel())->setTerminal(true);
        //echo('<h3>'.__METHOD__.'</h3>');
        //disable view and laypout
        //return $this->getResponse();
       // return $this->response();
    }

    public function editAction()
    {
        echo 'edu';
        //return false;
    } 
}

?>