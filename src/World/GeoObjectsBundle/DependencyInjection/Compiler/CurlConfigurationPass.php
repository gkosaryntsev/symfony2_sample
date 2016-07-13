<?php
/*
 * This file is part of the GeoObjectsBundle package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace World\GeoObjectsBundle\DependencyInjection\Compiler;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
/**
 * Checks if a curl bundle is set.
 *
 * @internal
 */
final class CurlConfigurationPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('anchovy.curl')) {
            throw new \InvalidArgumentException('Service called "anchovy.curl" (anchovy/curl-bundle package) is not available. You must enable the AnchovyCURLBundle.');
        }
    }
}