<?php
namespace Foods\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Foods\Model\FoodsTable;
use Foods\Model\Food;
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

    
            if($form->isValid()){
                $data = $form->getData();
            
                // echo '<pre>';    
                // print_r($data);
                // echo '</pre>'; 
                
                if(!empty($data['image']['name']))
                {
                    //update ảnh
                    //đổi tên file ảnh

                    $newName =  date('Y-m-d-h-i-s').'-'.$file['image']['name'];
                    $image  =new \Zend\Filter\File\Rename([
                        'target' => IMAGE_PATH.'hinh_mon_an/'.$newName,
                        'overwrite' => true
                    ]);
                    $image->filter($file['image']);
                    $data['image'] = $newName; // chỉ lấy tên file
                }
                else
                {
                    $data['image'] = '';
                }
                //bổ sung trường
                $data['update_at']=date('Y-m-d');
                
                $data['promotion'] = isset($data['promotion'] ) ? implode(", ", $data['promotion']) : '';//nối mảng
                
            
                //lưu
                $food = new Food();
                $food->exchangeArray($data);
                // try{
                    $this->table->saveFoods($food);

                    $this->flashMessenger()->addSuccessMessage('Thêm thành công!');
                    //trở về trang danh sách
                    return $this->redirect()->toRoute('Foods',['controller'=>'FoodsController', 'action'=>'index']);
                // }
                // catch(Exception $e)
                // {
                //     $this->flashMessenger()->addErrorMessage('Thêm thất bại! Lỗi '.$e->getMessage());
                // }
           }
           else{
                $this->flashMessenger()->addErrorMessage('Thêm thất bại!');
           }

        }
        return new ViewModel(['form' => $form]);
    }

    public function editAction()
    {
        $id=(int)$this->params()->fromRoute('id', 0);
        if($id==0){
            return $this->redirect()->toRoute('Foods',['controller'=>'FoodsController', 'action'=>'index']);
        }
        $food = $this->table->findFood($id);
        // echo '<pre>';    
        // print_r($food);
        // echo '</pre>'; 
            
        $form = new FoodForm();
        $form->bind($food);
        
        $foodTypes = $this->table->getFoodTypes();
        //taoj mang co dang (id=>name)
        $listTypes = [];
        foreach($foodTypes as $ft)
            $listTypes[$ft->id] = $ft->name;
        
        $form->get("id_type")->setValueOptions($listTypes);

        //update
        $request = $this->getRequest();
        if($request->isPost()){

            $data = $request->getPost()->toArray();
            $file = $request->getFiles()->toArray();
            


            //merge
            $data = array_merge_recursive($data, $file);
            $form->setData($data);
    // echo '<pre>';    
    //         print_r($data);
    //         echo '</pre>'; 
    //         die;   
        
            
                
            if($form->isValid()){
                // $data = $form->getData(); 
    // echo '<pre>';    
    //         print_r($data);
    //         echo '</pre>'; 
    //         die;   
            
                
                // bổ sung trường
                $data['update_at'] = date('Y-m-d');
                
                $data['promotion'] = isset($data['promotion'] ) ? implode(", ", $data['promotion']) : '';//nối mảng
                
                // echo '<pre>';    
                // print_r($data);
                // echo '</pre>'; 
                // die;
                
                if(!empty($data['image']['name']))
                {
                    //update ảnh
                    //đổi tên file ảnh
    
                    $newName =  date('Y-m-d-h-i-s').'-'.$file['image']['name'];
                    $image  = new \Zend\Filter\File\Rename([
                        'target' => IMAGE_PATH.'hinh_mon_an/'.$newName,
                        'overwrite' => true
                    ]);
                    $image->filter($file['image']);
    
                    $data['image'] = $newName; // chỉ lấy tên file
                }
                else
                {
                    
                    $data['image'] = $form->get('image')->getValue();
                }
                
                //lưu
                $food = new Food();
                $food->exchangeArray($data);
         
                    $this->table->saveFoods($food);

                    $this->flashMessenger()->addSuccessMessage('Sửa thành công!');
                    //trở về trang danh sách
                    return $this->redirect()->toRoute('Foods',['controller'=>'FoodsController', 'action'=>'index']);
         
           }

        }

        return  new ViewModel(['form' => $form]);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('Foods');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteFood($id);
                $this->flashMessenger()->addSuccessMessage('Da xóa!');
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('Foods');
        }

        return [
            'id'    => $id,
            'food' => $this->table->findFood($id),
        ];
    }
    
}
?>