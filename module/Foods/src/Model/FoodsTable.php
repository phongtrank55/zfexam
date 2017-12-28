<?php
namespace Foods\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Db\Sql\Sql;

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
}

?>