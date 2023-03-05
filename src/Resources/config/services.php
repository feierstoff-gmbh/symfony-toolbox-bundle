<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Feierstoff\ToolboxBundle\ApiGenerator\ApiDocGenerator;
use Feierstoff\ToolboxBundle\ApiGenerator\Parameter\InjectParameters;
use Feierstoff\ToolboxBundle\Serializer\Serializer;

return function(ContainerConfigurator $container) {

    $container->services()
        ->set(ApiDocGenerator::class)
            ->arg("\$router", service("router.default"))
            ->alias("feierstoff_toolbox.service.api_doc_generator", ApiDocGenerator::class)
        ->set(Serializer::class)
            ->alias("feierstoff_toolbox.service.serializer", Serializer::class)
        ->set(InjectParameters::class)
            ->alias("feierstoff_toolbox.service.inject_parameters", InjectParameters::class)
    ;
};