<?php

return function (\Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator $routes) {
    $routes
        ->add("feierstoff.toolbox_bundle.route.api_doc.index", "/docs")
        ->controller([\Feierstoff\ToolboxBundle\Route\ApiDocRoute::class, "index"])
    ;
};