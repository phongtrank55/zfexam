<?php
namespace Database\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Ddl;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Ddl\Column;


class DdlController extends AbstractActionController
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

    public function createTableAction()
    {
        $table = new Ddl\CreateTable("demo2");
        $table->addColumn((new Column\Integer('id'))
                                ->setOption('AUTO_INCREMENT', true));
        $table->addColumn(new Column\Varchar('name', 255));

        $table->addConstraint(new Ddl\Constraint\PrimaryKey('id'));
        $table->addConstraint(new Ddl\Constraint\UniqueKey(['name'], 'my_unique'));

        $sql = new Sql($this->adapter);
        $this->adapter->query(
            $sql->getSqlStringForSqlObject($table),
            Adapter::QUERY_MODE_EXECUTE
        );
        echo 'Excuted';
        echo '<br>';
        echo $sql->getSqlStringForSqlObject($table);
        return false;
    }

    public function alterTableAction()
    {
        $table = new Ddl\AlterTable("demo2");
        $table->addColumn(new Column\Varchar('email', 50));
                                
        $table->changeColumn('name', new Column\Varchar('name', 100));

        // $table->dropColumn('foo');
        // $table->dropConstraint('my_index');
        
        $sql = new Sql($this->adapter);
        $this->adapter->query(
            $sql->getSqlStringForSqlObject($table),
            Adapter::QUERY_MODE_EXECUTE
        );
        echo 'Excuted';
        echo '<br>';
        echo $sql->getSqlStringForSqlObject($table);
        return false;
    }

    public function createTable02Action()
    {
        $table = new Ddl\CreateTable("demo3");
        $table->addColumn((new Column\Integer('id'))
                                ->setOption('AUTO_INCREMENT', true));
        $table->addConstraint(new Ddl\Constraint\PrimaryKey('id'));
        $table->addColumn(new Column\Varchar('name', 255));
        
        $table->addColumn(new Column\Integer('id_demo2'));
        $table->addConstraint(new Ddl\Constraint\ForeignKey('my_foregin', 'id_demo2', 'demo2', 'id'));


        $sql = new Sql($this->adapter);
        $this->adapter->query(
            $sql->getSqlStringForSqlObject($table),
            Adapter::QUERY_MODE_EXECUTE
        );
        echo 'Excuted';
        echo '<br>';
        echo $sql->getSqlStringForSqlObject($table);
        return false;
    }
    
    public function dropTableAction()
    {
        $table = new Ddl\DropTable("demo3");
        $sql = new Sql($this->adapter);
        $this->adapter->query(
            $sql->getSqlStringForSqlObject($table),
            Adapter::QUERY_MODE_EXECUTE
        );
        echo 'Excuted';
        echo '<br>';
        echo $sql->getSqlStringForSqlObject($table);
        return false;
    }
    
}


?>