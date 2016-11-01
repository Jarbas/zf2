<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Bits\Controller\Bits' => 'Bits\Controller\BitsController'
        ),
    ),

    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'bits' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/bits[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Bits\Controller\Bits',
                        'action'     => 'index',
                    ),
                ),
            ),

        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'album' => __DIR__ . '/../view',
        ),
    ),
);