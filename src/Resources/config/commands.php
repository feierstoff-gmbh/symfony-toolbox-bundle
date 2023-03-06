<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Feierstoff\ToolboxBundle\Command\GenerateKeyCommand;

return function(ContainerConfigurator $container) {
    $tag = "console.command";

    $container->services()
        ->set(GenerateKeyCommand::class)
            ->tag($tag)
            ->arg("\$em", service("doctrine.orm.entity_manager"))
    ;
};