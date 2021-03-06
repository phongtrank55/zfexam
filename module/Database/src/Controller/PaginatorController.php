<?php
namespace Database\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter;
use Zend\Db\Adapter\Adapter as ADB;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;

class PaginatorController extends AbstractActionController
{
    private $adapterDB;

    public function __construct()
    {
            
        $this->adapterDB = new ADB([
            'hostname'=>'localhost',
            'database'=>'resstaurant',
            'username'=>'root',
            'password'=>'',
            'driver'=>'Pdo_Mysql',
            'charset'=>'utf8'
        ]);
    }

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
 
        return new ViewModel(['paginator'=>$paginator]);
    }


    public function index02Action()
    {
        $select = new Select();
        $select->from('foods');
        
        $dbSelect = new DbSelect($select, $this->adapterDB);

        $paginator = new Paginator($dbSelect);

        $currentPage = $this->params()->fromRoute('page', 1);

        $paginator->setCurrentPageNumber($currentPage);
        $paginator->setPageRange(3); //Số link trên trang
        $paginator->setItemCountPerPage(10);

        return new ViewModel(['paginator' => $paginator]);
    }
}


?>