<?php
namespace Food2\Model;

use Zend\Db\Sql\Sql;

class FoodTable
{
   private $tableGateway;

   public function __construct($tableGateway)
   {
        $this->tableGateway = $tableGateway;
   }
   
   public function fetchByTypeId($typeId)
   {
        return $this->tableGateway->select(['id_type' => $typeId]);
   }

   public function getFoodTypes()
   {
        $adapter = $this->tableGateway->getAdapter();
        $sql = new Sql($adapter);
        $select = $sql->select("food_type")->columns(['id', 'name']);
        $selectString = $sql->buildSqlString($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);  
        return $results;
        
   }
}

?>