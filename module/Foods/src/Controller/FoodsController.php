<?php
namespace Foods\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Foods\Model\FoodsTable;

class FoodsController extends AbstractActionController
{
    private $table;

    public function __construct(FoodsTable $table){
        $this->table = $table;
    
    }

    public function indexAction()
    {
        $foods = $this->table->fetchAll();
        
        // echo '<pre>';
        // foreach($foods as $food)
        // print_r($food);
        // echo '</pre>';
        
        return new ViewModel(['foods' => $foods]);
    }

    // public function getTableNameAction()
    // {
    //     echo $this->table->getTableName();
    //     return false;
    // }

    // public function selectDataAction()
    // {
    //     echo '<pre>';
    //     $results= $this->table->selectData();
    //     foreach($results as $result)
    //         print_r($result); 
    //     echo '</pre>';
    //     return false;
    // }

    
    public function addAction()
    {

    }
    public function editAction()
    {

    }

    public function deleteAction()
    {

    }
    
}
?>