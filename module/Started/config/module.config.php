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
            // 'Started' => [
            //     'type'    => Segment::class,
            //     'options' => [
            //         'route'    => '/started[/:action]',
            //         'defaults' => [
            //             'controller' => Controller\IndexController::class,
            //             'action'     => 'index',
            //         ],
            //     ],
            // ],
            // 'started'=>[
            //     'type'=>Literal::class,
            //     'options'=>[
            //         'route'=>'/started',
            //         'defaults'=>[
            //             'controller'=>Controller\IndexController::class,
            //             'action'=>'index'
            //         ],
            //     ],
            // ],
            // 'started-edit'=>[
            //     'type'=>Literal::class,
            //     'options'=>[
            //         'route'=>'/started/edit',
            //         'defaults'=>[
            //             'controller'=>Controller\IndexController::class,
            //             'action'=>'edit'
            //         ]
            //     ]
            // ]
            'started'=>[
                'type'=>Segment::class,
                'options'=>[
                    'route'=>'/started',
                    //'route'=>'/started[/:action][/:id]',
                    'defaults'=>[
                        'controller'=>Controller\IndexController::class,
                        'action'=>'index'
                    ],
                    // 'constraints'=>[
                    //     'action'=>'[a-zA-Z0-9]*',
                    //     'id'=>'[0-9]*'
                    // ],
                ],
                'may_terminate'=>false,
                'child_routes'=>[
                    'sub_route'=>[//name 1 child_route
                        'type'=>Segment::class,
                        'options'=>[
                            'route'=>'[/:action][/:id]',
                            'constraints'=>[
                                'action'=>'[a-zA-Z0-9]*',
                                'id'=>'[0-9]*'
                            ],      
                            'defaults'=>[
                                'controller'=>Controller\UserController::class,
                                'action'=>'index'
                            ],
                        ]
                        
                        ],
                        // 'login_route'=>[//name 1 child_route
                    //     'type'=>Literal::class,
                    //     'options'=>[
                    //         'route'=>'/login',
                    //         'defaults'=>[
                    //             'controller'=>Controller\UserController::class,
                    //             'action'=>'login'
                    //         ],
                    //     ],
                    // ],
                    //     'logout_route'=>[//name 1 child_route
                    //         'type'=>Literal::class,
                    //         'options'=>[
                    //             'route'=>'/logout',
                    //             'defaults'=>[
                    //                 'controller'=>Controller\UserController::class,
                    //                 'action'=>'logout'
                    //             ],
                    //         ]
                    //     ]
                    
                    

                ],

            ]
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Started\Controller\Factory\IndexControllerFactory::class,
            Controller\UserController::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
