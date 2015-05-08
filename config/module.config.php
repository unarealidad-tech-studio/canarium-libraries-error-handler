<?php

return array(
    'error_handler' => array(
        'notfound_strategy' => 'ErrorHandler\View\NotFoundStrategy',

        // Template name for the not found strategy
        'template'              => 'error/404-error-handler',
    ),

    'service_manager' => array(
        'factories' => array(
            'ErrorHandler\Config'                   => 'ErrorHandler\Service\ConfigServiceFactory',
			'ErrorHandler\View\NotFoundStrategy' => 'ErrorHandler\Service\NotFoundStrategyServiceFactory',
        ),
    ),

    'view_manager' => array(
        'template_map' => array(
            'error/404-error-handler' => __DIR__ . '/../view/error/404.phtml',
        ),
    ),
);
