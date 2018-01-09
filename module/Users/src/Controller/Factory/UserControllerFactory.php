<?php
namespace Users\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\ServiceManager;
use Users\Controller\UserController;
use Users\Service\UserManager;

class UserControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $dependency = $container->get("doctrine.entitymanager.orm_default");
        $userManager = $container->get(UserManager::class);
        return new UserController($dependency, $userManager);
    }
}

?>