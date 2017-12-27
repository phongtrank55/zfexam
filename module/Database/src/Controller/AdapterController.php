<?php
namespace Database\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Adapter\Adapter;

class AdapterController extends AbstractActionController
{
    public function adapterDb()
    {
        $adapter = new  Adapter([
            'driver' => 'Pdo_Mysql',
            'database'=>'resstaurant',
            'username'=>'root',
            'password' => '',
            'hostname' => 'localhost',
            'charset'=>'utf8'
        ]);
        return $adapter;
    }

    public function indexAction()
    {
        
        $db = $this->adapterDb();
        $stm = $db->query("SELECT * FROM food_type LIMIT 0, 4");
        $result = $stm->execute();
        
                // echo '<pre>';
        // print_r($result);
        // echo '</pre>';

        foreach($result as $row)
        {
            echo '<pre>';
            print_r($row);
            echo '</pre>';

        }
        return false;
    }

    public function demo02Action()
    {
        $db = $this->adapterDb();
        
        // $stm = $db->query("SELECT * FROM food_type WHERE id < ?");
        // $result = $stm->execute([5]);
        
        //  $stm = $db->createStatement("SELECT * FROM food_type WHERE id < ?", [5]);
        //  $result = $stm->execute();


        //  $stm = $db->createStatement("SELECT * FROM food_type WHERE id BETWEEN ? AND ?", [5, 7]);
        //  $result = $stm->execute();

         $stm = $db->createStatement("SELECT * FROM food_type WHERE id BETWEEN :start AND :end", ['start'=>5, 'end'=>10]);
         $result = $stm->execute();

         
        foreach($result as $row)
        {
            echo '<pre>';
            print_r($row);
            echo '</pre>';

        }
        return false;
    }


    public function demo03Action()
    {
        $db = $this->adapterDb();
        $qi = function($name) use ($db){
            return $db->platform->quoteIdentifier($name);
        };
        $fp = function($name) use($db){
            return $db->driver->formatParameterName($name);
        };

        // $sql = "SELECT * FROM ".$qi("food_type")." WHERE ".$qi("id")." = ".$fp("ID");
        // $sql = "SELECT * FROM ".$qi("food_type")." WHERE ".$qi("id")." = ".$fp("ID")." OR ". $qi("name")." LIKE ".$fp("name");
        $sql = sprintf("SELECT * FROM %s WHERE %s=%s or %s like %s", $qi('food_type'), $qi("id"), $fp('ID'), $qi('name'), $fp('name'));


        $stm = $db->createStatement($sql, ['ID'=>2, "name"=>"%c%"]);
         $result = $stm->execute();

         
        foreach($result as $row)
        {
            echo '<pre>';
            print_r($row);
            echo '</pre>';

        }
        return false;
    }

    public function demo04Action()
    {
        $db = $this->adapterDb();
        $qi = function($name) use ($db){
            return $db->platform->quoteIdentifier($name);
        };
        $fp = function($name) use($db){
            return $db->driver->formatParameterName($name);
        };

        $sql = sprintf("INSERT INTO %s(%s, %s, %s) VALUES(%s, %s, %s)",
                $qi('food_type'), $qi("NAMe"), $qi("description"), $qi("image"), 
                $fp('name'), $fp('description'), $fp('image'));


        $stm = $db->createStatement($sql, ['name'=>"Bún Huế", "description"=>"Ngon", "image"=>"bunhue.jpg"]);
         $result = $stm->execute();

        echo '<pre>';
        print_r($result);
        echo '</pre>';
        
        return false;
    }

    
}


?>