<?php

namespace Bundle\BreadcrumbBundle;

use Bundle\BreadcrumbBundle\DependencyInjection\Compiler\BreadcrumbsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle as BaseBundle;

class BreadcrumbBundle extends BaseBundle
{
    public function registerExtensions(ContainerBuilder $container)
    {
        parent::registerExtensions($container);
        $container->addCompilerPass(new BreadcrumbsPass());
    }
    
    /**
	 * {@inheritdoc}
	 */
    public function getNamespace()
    {
        return __NAMESPACE__;
    }

    /**
	 * {@inheritdoc}
	 */
    public function getPath()
    {
        return strtr(__DIR__, '\\', '/');
    }
}