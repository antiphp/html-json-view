<?php
return array(
    'view_manager' => array(
        'strategies' => array(
            'htmlJsonStrategy'
        )
    ),
    'service_manager' => array(
        'factories' => array(
            'htmlJsonRenderer' => 'Antiphp\View\Renderer\HtmlJsonRendererServiceFactory',
            'htmlJsonStrategy' => 'Antiphp\View\Strategy\HtmlJsonStrategyServiceFactory',
        )
    )
);