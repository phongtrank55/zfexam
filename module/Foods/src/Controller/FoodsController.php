<?php
namespace Foods\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Foods\Model\FoodsTable;
use Foods\Form\FoodForm;

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
        $form = new FoodForm();
           // echo '<pre>';    
        // foreach($foodTypes as $result)
        //     print_r($result); 
        // echo '</pre>';
        // die;
     
        $foodTypes = $this->table->getFoodTypes();
        //taoj mang co dang (id=>name)
        $listTypes = [];
        foreach($foodTypes as $ft)
            $listTypes[$ft->id] = $ft->name;
        
        $form->get("id_type")->setValueOptions($listTypes);
     
        $request = $this->getRequest();
        if($request->isPost()){
            $data = $request->getPost()->toArray();
            $file = $request->getFiles()->toArray();

            //merge
            $data = array_merge_recursive($data, $file);
  
            $form->setData($data);

            // echo '<pre>';    
            // print_r($data);
        
            // echo '</pre>';    

            if($form->isValid()){
                $data = $form->getData();
                echo '<pre>';    
                print_r($data);
            
                echo '</pre>';    
           }
        }
        return new ViewModel(['form' => $form]);
    }
    public function editAction()
    {

    }

    public function deleteAction()
    {

    }
    
}
?>