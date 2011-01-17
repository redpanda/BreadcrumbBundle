<?php

namespace Bundle\BreadcrumbBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

use Bundle\BreadcrumbBundle\Twig\BreadcrumbsTokenParser;

class BreadcrumbsExtension extends \Twig_Extension
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * @var array
     */
    protected $breadcrumbs = array();

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     * @return void
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        $this->breadcrumbs = $this->container->getParameter('breadcrumbs.services');
    }

    /**
     * @return array
     */
    public function getTokenParsers()
    {
        return array(
            // {% breadcrumbs "name" %}
            new BreadcrumbsTokenParser(),
        );
    }

    /**
     * @param string $name
     * @return \Bundle\BreadcrumbBundle\Breadcrumbs
     * @throws \InvalidArgumentException
     */
    public function get($name)
    {
        if (!isset($this->breadcrumbs[$name])) {
            throw new \InvalidArgumentException(sprintf('The breadcrumbs "%s" is not defined.', $name));
        }

        if (is_string($this->breadcrumbs[$name])) {
            $this->breadcrumbs[$name] = $this->container->get($this->breadcrumbs[$name]);
        }

        return $this->breadcrumbs[$name];
    }

    /**
     * @param string $name
     * @return string
     */
    public function render($name)
    {
        return $this->get($name)->render();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'breadcrumbs';
    }
}

