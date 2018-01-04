<?php
namespace Database\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter;

class PaginatorController extends AbstractActionController
{
    // private $adapter;

    // public function __construct()
    // {
            
    //     $this->adapter = new Adapter([
    //         'hostname'=>'localhost',
    //         'database'=>'resstaurant',
    //         'username'=>'root',
    //         'password'=>'',
    //         'driver'=>'Pdo_Mysql',
    //         'charset'=>'utf8'
    //     ]);
    // }

    public function indexAction()
    {
        $arrayData =[
            ['name'=>"San pham 1", 'price'=> '20000'],
            ['name'=>"San pham 2", 'price'=> '20000'],
            ['name'=>"San pham 3", 'price'=> '20000'],
            ['name'=>"San pham 4", 'price'=> '20000'],
            ['name'=>"San pham 5", 'price'=> '20000'],
            ['name'=>"San pham 6", 'price'=> '20000'],
            ['name'=>"San pham 7", 'price'=> '20000'],
            ['name'=>"San pham 8", 'price'=> '20000'],
            ['name'=>"San pham 9", 'price'=> '20000'],
            ['name'=>"San pham 10", 'price'=> '20000'],
            ['name'=>"San pham 11", 'price'=> '20000'],
            ['name'=>"San pham 12", 'price'=> '20000'],
            ['name'=>"San pham 13", 'price'=> '20000'],
        ];

        
        $paginator = new Paginator(new Adapter\ArrayAdapter($arrayData));

        $currentPage = $this->params()->fromRoute('page', 1);
        $paginator->setCurrentPageNumber($currentPage);
        $paginator->setItemCountPerPage(5);
        $view = new ViewModel(['paginator'=>$paginator]);

        return $view;
    }

}


?>