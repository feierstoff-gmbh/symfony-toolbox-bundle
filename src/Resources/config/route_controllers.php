<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Feierstoff\ToolboxBundle\ApiGenerator\ApiDocGenerator;
use Feierstoff\ToolboxBundle\Route\ApiDocRoute;

return function(ContainerConfigurator $container) {
    $container->services()
        ->set(ApiDocRoute::class)
            ->tag("controller.service_arguments")
            ->arg("\$twig", service("twig"))
            ->arg("\$apiDocGenerator", service(ApiDocGenerator::class))
            ->alias("feierstoff.toolbox_bundle.route.api_doc", ApiDocRoute::class)
            ->public()
    ;
};