<?php
namespace Food2\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Food2\Model\FoodTable;
use Food2\Model\Food;

class FoodController extends AbstractActionController
{
    private $table;

    public function __construct(FoodTable $table){
        $this->table = $table;
    
    }
    public function indexAction()
    {
        $foodTypes = $this->table->getFoodTypes();
        $types = [];
        foreach($foodTypes as $foodType)
            $types[$foodType->id] = $foodType->name;
        
        $form = new \Zend\Form\Form();
        $form->setAttribute('id', 'formType');
        $form->add([
            'name' => 'typeId',
            'type' => 'select',
            'options' => [
                'label' => 'Chọn loại: ',
                'value_options' => $types
            ],
            'attributes' => [
                'class' => 'form-control',
                'id' => 'typeId'
            ]

        ]);
        $view = new ViewModel(['form'=>$form]);
        
        if($this->getRequest()->isXmlHttpRequest())
        {
            
            $stt=1;
            $typeId = $this->params()->fromPost('typeId', 1);
            $foods = $this->table->fetchByTypeId($typeId);    
            if($foods->count()==0)
            {
                echo '<tr><td colspan="6">Không có dữ liệu</td></tr>';
            }
            else{
            foreach($foods as $food){
                
                echo '<tr>';
                echo '<td>'. $stt++ .'</td>';
               
                echo '<td>'. $food->name.' </td>';
             
                echo '<td>'. $food->summary.' </td>';
                
                echo '<td>'. $food->price.' </td>';
                echo '<td>'. $food->promotion.' </td>';
                echo '</tr>';
                
            }
        }
            return $this->getResponse(); //LOAIJ BOR layout
        }
        
        // 'foods'=>$foods, 
    return $view;

    }
}

?>
