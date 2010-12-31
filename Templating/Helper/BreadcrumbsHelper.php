<?php

namespace Bundle\BreadcrumbsBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Bundle\BreadcrumbsBundle\BreadcrumbItem;

class BreadcrumbsHelper extends Helper implements \ArrayAccess
{
    /**
	* @var \Symfony\Component\DependencyInjection\ContainerInterface
	*/
    protected $container;

    /**
	* @var array
	*/
    protected $breadcrumbs;

    /**
	* @param \Symfony\Component\DependencyInjection\ContainerInterface $container
	* @return void
	*/
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        $this->breadcrumbs = array();
        foreach ($this->container->findTaggedServiceIds('breadcrumbs') as $id => $attributes) {
            if (isset($attributes[0]['alias'])) {
                $this->breadcrumbs[$attributes[0]['alias']] = $id;
            }
        }
    }

    /**
	* Render the menu
	*
	* @param string $name
	* @param integer $depth (optional)
	* @return string
	*/
    public function render($name, $depth = null)
    {
        return $this->get($name)->render($depth);
    }

    /**
	* @param string $name
	* @return \Bundle\BreadcrumbsBundle\Breadcrumbs
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
	* @return string
	*/
    public function getName()
    {
        return 'breadcrumbs';
    }

    /**
	* Implements ArrayAccess
	*/
    public function offsetExists($name)
    {
        return isset($this->breadcrumbs[$name]);
    }

    /**
	* Implements ArrayAccess
	*/
    public function offsetGet($name)
    {
        return $this->get($name);
    }

    /**
	* Implements ArrayAccess
	*/
    public function offsetSet($name, $value)
    {
        return $this->breadcrumbs[$name] = $value;
    }

    /**
	* Implements ArrayAccess
	*/
    public function offsetUnset($name)
    {
        throw new \LogicException(sprintf('You can\'t unset a breadcrumbs from a template (%s).', $id));
    }
}