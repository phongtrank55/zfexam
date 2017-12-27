<?php

namespace Training;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
    return array(
        // router
        'router' => [
            'routes' => [
               
                'Training' => [
                    'type'    => Segment::class,
                    'options' => [
                        'route'    => '/training[/:action]',
                        'defaults' => [
                            'controller' => Controller\IndexController::class,
                            'action'     => 'index',
                        ],
                    ],
                ],
            ],
        ],
        
        //controllers
        'controllers' => [
            'invokables' =>[
                'Training\Controller\Index' =>  'Training\Controller\IndexController',
            ],
            // 'factories' => [
            //     Controller\IndexController::class => InvokableFactory::class,
            // ],
        ], 


        'view_manager' =>array(
            'template_map' => [
                'training/index/index' => __DIR__ . '/../view/training/index/index.phtml'
            ],
            'template_path_stack'=>[ __DIR__ . '/../view',]
        )
        
        
    );

?>