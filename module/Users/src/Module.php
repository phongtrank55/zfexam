<?php
namespace Users;

use Zend\Mvc\MvcEvent;

class Module
{
    public function getConfig()
    {
       
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespace' =>[
                    __NAMESPACE__ => __DIR__.'/src/'.__NAMESPACE__
                ]
            ]
        ];
    }
    
    public function onBootstrap(MvcEvent $event)
    {
        $eventManager = $event->getApplication()->getEventManager();
        $sharedEventManager = $eventManager->getSharedManager();
        $sharedEventManager->attach('Zend\Mvc\Controller\AbstractActionController', 
                                        MvcEvent::EVENT_DISPATCH, 
                                        [$this, 'onDispatch'], 100);

    }

    public function onDispatch(MvcEvent $event)
    {
        $controllerName = $event->getRouteMatch()->getParam('controller', null);
        $actionName = $event->getRouteMatch()->getParam('action', null);

        $authManager = $event->getApplication()->getServiceManager()->get('Users\Service\AuthManager');
        if(!$authManager->filterAccess($controllerName, $actionName) /*&& $controllerName!='Users\Controller\AuthController'*/)
        {
            //neu khong co quyen
            $controller = $event->getTarget();//lay doi tuong controller dang chay
            return $controller->redirect()->toRoute('login');
        }
    }
}