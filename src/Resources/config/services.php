<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Feierstoff\ToolboxBundle\ApiGenerator\ApiDocGenerator;

return function(ContainerConfigurator $container) {

    $container->services()
        ->set(ApiDocGenerator::class)
        ->arg("\$router", service("router.default"))
        ->alias("feierstoff_toolbox.service.api_doc_generator", ApiDocGenerator::class)
    ;

};