<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonHello for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Users;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'user' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/user[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'index',
                        
                    ],
                    'constraints' =>[
                        'action'=> '[a-zA-Z][a-zA-Z0-9]*',
                        'id'=> '[0-9]+',
                    ]
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            
            Controller\UserController::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
          'users' => __DIR__ . '/../view',
        ],
    ],
    'doctrine' => [
        'driver' => [
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            __NAMESPACE__.'_driver' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__.'/../src/Entity'
                ],
            ],

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => [
                'drivers' => [
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                   __NAMESPACE__.'\Entity' =>  __NAMESPACE__.'_driver' 
                ],
            ],
        ],
    ],
];