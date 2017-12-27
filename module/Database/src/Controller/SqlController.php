<?php
namespace Database\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;

class SqlController extends AbstractActionController
{
    private $adapter;

    public function __construct()
    {
            
        $this->adapter = new Adapter([
            'hostname'=>'localhost',
            'database'=>'resstaurant',
            'username'=>'root',
            'password'=>'',
            'driver'=>'Pdo_Mysql',
            'charset'=>'utf8'
        ]);
    }

    public function selectAction()
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select()->from("foods")->where(["id"=>2]);

        // $stm = $sql->prepareStatementForSqlObject($select);
        // $results = $stm->execute();

        $selectString = $sql->buildSqlString($select);
         $results = $this->adapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);  
        foreach($results as $result){
            echo '<pre>';
            print_r($result);
            echo '</pre>';
        }
        return false;
    }

    public function select02Action()
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select()
                    ->from(['f'=>'foods'])
                    ->columns(['mamon'=>'ID', 'tenmon'=>'name'])
                    ->where(["id"=>2]);

        $stm = $sql->prepareStatementForSqlObject($select);
        $results = $stm->execute();

        foreach($results as $result){
            echo '<pre>';
            print_r($result);
            echo '</pre>';
        }
        return false;
    }

    //join
    public function select03Action()
    {
        $sql = new Sql($this->adapter);

        $select = $sql->select();
        $select->from(['f'=>"foods"])
                    ->columns(['Tên'=>'name'])
                    ->join(['ft'=>'food_type'], //BẢNG CẦN NỐI
                        'f.id_type=ft.id',//Điều kiện
                         ['name_type'=>'name'],//Các cột của bảng cần nối (option)
                          $select::JOIN_INNER); //kiểu nối (option)
                    // ->where(['ft.id'=>2]);


        $stm = $sql->prepareStatementForSqlObject($select);
        $results = $stm->execute();

        foreach($results as $result){
            echo '<pre>';
            print_r($result);
            echo '</pre>';
        }
        return false;
    }

    //where
    public function select04Action()
    {
        $sql = new Sql($this->adapter);

        $select = $sql->select("foods");
        // $select->where(function(Where $where){
        //     $where->like('name', '%súp%');
        // });

        // $select->where('id_type=2 AND price<50000');
        $select->where(['id_type=2', 'price<50000']);

        // $select->where('id_type=2 or price<50000');

        $stm = $sql->prepareStatementForSqlObject($select);
        $results = $stm->execute();

        foreach($results as $result){
            echo '<pre>';
            print_r($result);
            echo '</pre>';
        }
        return false;
    }

    public function select05Action()
    {
        $sql = new Sql($this->adapter);

        $select = $sql->select("foods");

        // $select->where(new \Zend\Db\Sql\Predicate\In('id',[1, 2, 3]));
        // $select->where(new \Zend\Db\Sql\Predicate\Between('id',5, 9));
        // $select->where(new \Zend\Db\Sql\Predicate\Expression('id = ? OR id = ?',[2, 9]));
        $select->where(new \Zend\Db\Sql\Predicate\Literal('id_type > 8'));

        // $select->where('id_type=2 or price<50000');

        $stm = $sql->prepareStatementForSqlObject($select);
        $results = $stm->execute();

        foreach($results as $result){
            echo '<pre>';
            print_r($result);
            echo '</pre>';
        }
        return false;
    }
    //order, LIMIT, OFFSET
    public function select06Action()
    {
        $sql = new Sql($this->adapter);

        $select = $sql->select("foods");

        // $select->order('id DESC');
        $select->order('id DESC, price ASC');

        $select->limit(5)->offset(3);
        $stm = $sql->prepareStatementForSqlObject($select);
        $results = $stm->execute();

        foreach($results as $result){
            echo '<pre>';
            print_r($result);
            echo '</pre>';
        }
        return false;
    }
    //group having
    public function select07Action()
    {
        $sql = new Sql($this->adapter);

        $select = $sql->select();
        
        $select->columns(['Ma loai'=>'id', 'Ten loai' => 'name', 'Tong SP'=>new \Zend\Db\Sql\Expression('count(f.id)')])
        ->from(['ft'=>'food_type'])
                ->join(['f'=>"foods"], 'f.id_type=ft.id', [], $select::JOIN_LEFT)
                ->group(['ft.id', 'ft.name']);
        

         $select->having("`tong sp`>5");
        $stm = $sql->prepareStatementForSqlObject($select);
        // print_r($stm);
        $results = $stm->execute();
        
        foreach($results as $result){
            echo '<pre>';
            print_r($result);
            echo '</pre>';
        }
        return false;
    }
    //tim don gia trung binh, min max...
    public function select08Action()
    {
        $sql = new Sql($this->adapter);

        $select = $sql->select(['ft'=>'food_type']);
        
        $select->columns(['Ma loai'=>'id', 'Ten loai' => 'name', 
                            'average_price'=>new \Zend\Db\Sql\Expression('avg(price)'),
                            'min_price'=>new \Zend\Db\Sql\Expression('min(price)'),
                            'max_price'=>new \Zend\Db\Sql\Expression('max(price)'),
                            'group_concat'=>new \Zend\Db\Sql\Expression("group_concat(f.name SEPARATOR '; ')"),
                            ])
                ->join(['f'=>"foods"], 'f.id_type=ft.id', [], $select::JOIN_LEFT)
                ->group(['ft.id', 'ft.name']);
        

        //  $select->having("`average_price`>5");
        $stm = $sql->prepareStatementForSqlObject($select);
        // print_r($stm);
        $results = $stm->execute();
        
        foreach($results as $result){
            echo '<pre>';
            print_r($result);
            echo '</pre>';
        }
        return false;
    }

    //multijoin
    public function select09Action()
    {
        $sql = new Sql($this->adapter);

        $select = $sql->select(['f'=>'foods']);
        
        $select->join(['md'=>"menu_detail"], 'md.id_food=f.id', [], $select::JOIN_LEFT)
                ->join(['m'=>"menu"], 'm.id=md.id_menu', [], $select::JOIN_LEFT)
                ->where("m.id=2");

        $stm = $sql->prepareStatementForSqlObject($select);
        $sqlString=$sql->getSqlStringForSqlObject($select);
        echo $sqlString;
        $results = $stm->execute();
        
        foreach($results as $result){
            echo '<pre>';
            print_r($result);
            echo '</pre>';
        }
        return false;
    }

    public function insertAction()
    {
        $sql = new Sql($this->adapter);
        $insert = $sql->insert('customers');
        $insert->values([
            'name'=>'pt',
            'gender'=>'name',
            'email'=>'pt@gmail.com',
            'address'=>'VN',
            // 'Phone'=> ''
            'note'=>'zfexam'
        ]);

        $stm = $sql->prepareStatementForSqlObject($insert);
        $results = $stm->execute();

        $sqlString=$sql->getSqlStringForSqlObject($insert);
        echo $sqlString;
       
        return false;
    } 

    public function updateAction()
    {
        $sql = new Sql($this->adapter);
        $update = $sql->update('customers');
        $update->set([
            'PHOne'=>'12356'
        ]);
        $update->where(['id'=>21]);
        $stm = $sql->prepareStatementForSqlObject($update);
        $results = $stm->execute();

        $sqlString=$sql->getSqlStringForSqlObject($update);
        echo $sqlString;
       
        return false;
    } 

    public function deleteAction()
    {
        $sql = new Sql($this->adapter);
        $delete = $sql->delete('customers');
        $delete->where(['id'=>22]);
        $stm = $sql->prepareStatementForSqlObject($delete);
        $results = $stm->execute();

        $sqlString=$sql->getSqlStringForSqlObject($delete);
        echo $sqlString;
       
        return false;
    } 
}
?>
