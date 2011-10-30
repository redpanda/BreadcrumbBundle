<?php
namespace Bundle\BreadcrumbBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class BreadcrumbsPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('twig.extension.breadcrumbs') && !$container->hasDefinition('templating.helper.breadcrumbs')) {
            return;
        }

        $breadcrumbs = array();

        foreach ($container->findTaggedServiceIds('breadcrumbs') as $id => $attributes) {
            if (isset($attributes[0]['alias'])) {
                $breadcrumbs[$attributes[0]['alias']] = $id;
            }
        }

        $container->setParameter('breadcrumbs.services', $breadcrumbs);
    }
}