<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Orcle\Controller\Orcle' => 'Orcle\Controller\OracleController'
        ),
    ),

    'router' => array(
        'routes' => array(
            'oracle' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/oracle[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Orcle\Controller\Orcle',
                        'action'     => 'index',
                    ),
                ),
            ),

        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'oracle' => __DIR__ . '/../view',
        ),
    ),
);