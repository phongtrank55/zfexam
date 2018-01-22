<?php
namespace Food2;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' =>[
                Model\FoodTable::class => function($container){
                    $tableGateway = $container->get(Model\FoodTableGateway::class);
                    
                    return new Model\FoodTable($tableGateway);
                },
        
                Model\FoodTableGateway::class => function($container){
                    
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Food());
                    return new TableGateway('foods', $dbAdapter, null, $resultSetPrototype);
                }

            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\FoodController::class => function($container){
                    return new Controller\FoodController(
                        $container->get(Model\FoodTable::class)
                    );
                }
            ],
        ];
    }
}
?>