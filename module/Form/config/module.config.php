<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonHello for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Form;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'Form' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/form[/:action]',
                    'defaults' => [
                        'controller' => Controller\FormElementController::class,
                        'action'     => 'index',
                    ],
                    'constraints' =>[
                        'action'=>'[a-zA-Z0-9_-]*'
                    ]
                ],
            ],
            'Validator' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/validator[/:action]',
                    'defaults' => [
                        'controller' => Controller\ValidatorController::class,
                        'action'     => 'string',
                    ],
                ],    
            ],
            'Validatorchain' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/validator-chain[/:action]',
                    'defaults' => [
                        'controller' => Controller\ValidatorChainController::class,
                        'action'     => 'index',
                    ],
                ],   
            ],
            'inputfilter' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/input-filter[/:action]',
                    'defaults' => [
                        'controller' => Controller\InputFilterController::class,
                        'action'     => 'index',
                    ],
                ],   
            ],
            'uploadfile' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/upload-file[/:action]',
                    'defaults' => [
                        'controller' => Controller\UploadFileController::class,
                        'action'     => 'index',
                    ],
                ],   
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\FormElementController::class => InvokableFactory::class,
            Controller\ValidatorController::class => InvokableFactory::class,
            Controller\ValidatorChainController::class => InvokableFactory::class,
            Controller\InputFilterController::class => InvokableFactory::class,
            Controller\UploadFileController::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
