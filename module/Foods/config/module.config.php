<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonHello for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Started;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'Foods' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/foods[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\FoodsComtroller::class,
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
            
            Controller\FoodsComtroller::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
          'foods' => __DIR__ . '/../view',
        ],
    ],
];
