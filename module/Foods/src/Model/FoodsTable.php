<?php
namespace Foods\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Db\Sql\Sql;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter;

class FoodsTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        // return $this->tableGateway->select();

        //Trả về FoodObject
        // $results = $this->tableGateway->select(function(\Zend\Db\Sql\Select $select){
        //     $select->join(['ft'=>'food_type'], 'foods.id_type=ft.id', ['name_type'=>'name']);            
        // });


        $adapter = $this->tableGateway->getAdapter();
        $sql = new Sql($adapter);
        $select = $sql->select(['f'=>'foods'])
                    ->join(['ft'=>'food_type'], 'f.id_type=ft.id', ['name_type'=>'name']);
        
        // //Trả về mảng ['name']
        // // $stm = $sql->prepareStatementForSqlObject($select);
        // // $results = $stm->execute();
        
        //Trả về đối tượng mảng obj->name
        $selectString = $sql->buildSqlString($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);  

        return $results;

    }

    public function fetchAll2($paginated = false)
    {
        $adapter = $this->tableGateway->getAdapter();
        $sql = new Sql($adapter);
        $select = $sql->select(['f'=>'foods'])
                    ->join(['ft'=>'food_type'], 'f.id_type=ft.id', ['name_type'=>'name']);
        
        if ($paginated) {
            // create a new Select object for the table album
            // $select = new Select('album');
            // // create a new result set based on the Album entity
            // $resultSetPrototype = new ResultSet();
            // $resultSetPrototype->setArrayObjectPrototype(new Album());
            // // create a new pagination adapter object

        
            $paginatorAdapter = new DbSelect(
                // our configured select object
                $select,
                // the adapter to run it against
                $this->tableGateway->getAdapter()
              
            );
            $paginator = new Paginator($paginatorAdapter);

            return $paginator;
        }
        // Trả về mảng ['name']
        $stm = $sql->prepareStatementForSqlObject($select);
        $results = $stm->execute();
        
        return $results;
    }

    public function getTableName()
    {
        return $this->tableGateway->getTable();
    }

    public function selectData()
    {
        $adapter = $this->tableGateway->getAdapter();
        $sql = new Sql($adapter);
        $select = $sql->select()->from("foods")->where(["id"=>2]);

        $stm = $sql->prepareStatementForSqlObject($select);
        $results = $stm->execute();

        return $results;
    }

    public function getFoodTypes(){
        $adapter = $this->tableGateway->getAdapter();
        $sql = new Sql($adapter);
        $select = $sql->select("food_type")->columns(['id', 'name']);
        $selectString = $sql->buildSqlString($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);  
        return $results;
    }

    public function saveFoods(Food $food){
        $data = [
            'id_type' => $food->id_type,
            'name' => $food->name,
            'summary' => $food->summary,
            'detail' => $food->detail,
            'price' => $food->price,
            'promotion' => $food->promotion,
            'image' => $food->image,
            'update_at' => $food->update_at,
            'unit' => $food->unit,
            'today' => $food->today,
        
        ];
        
        
        if(empty($food->id))
            $this->tableGateway->insert($data);
        else if(!$this->findFood($food->id))
            throw new RuntimeException("Không tìm thấy món ăn có id là $id");
        else
            $this->tableGateway->update($data, ['id' => $food->id]);
    }

    public function findFood($id)
    {
        // $id = (int)$id;
        $food = $this->tableGateway->select(['id'=>$id])->current();
        if(!$food){
            throw new RuntimeException("Không tìm thấy món ăn có id là $id");

        }
        return $food;
    }

    public function deleteFood($id){
        $this->tableGateway->delete(['id'=>$id]);
    }

}

?>