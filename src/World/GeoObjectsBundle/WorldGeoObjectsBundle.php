<?php

namespace World\GeoObjectsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use World\GeoObjectsBundle\DependencyInjection\Compiler\CurlConfigurationPass;

class WorldGeoObjectsBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new CurlConfigurationPass());
    }
}
