<?php
namespace Bundle\BreadcrumbBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Bundle\BreadcrumbBundle\Renderer\ListRenderer;
use Bundle\BreadcrumbBundle\Renderer\RendererInterface;

class Breadcrumbs implements \ArrayAccess, \Countable, \IteratorAggregate
{
	protected $currentRoute = null;
	protected $rootName = null;
	protected $rootUri = null;
	protected $root = false;
	protected $lost = 'Lost';
	protected $separator = '&nbsp;&gt;&nbsp;';
	protected $children = array();
	protected $childClass = null;
	protected $renderer = null;
	protected $request = null;

	public function __construct(ContainerInterface $container = null, $childClass = 'Bundle\BreadcrumbBundle\BreadcrumbItem')
	{
		$this->childClass = $childClass;
		$this->container = $container;
		$this->currentRoute = $this->container->get('request')->get('_route');
	}

	public function getContainer()
	{
		return $this->container;
	}

	public function setRoot($name, $route = null)
	{
		if (!$name) {
			throw new Exception('You must provide a name for the root');
		}

		$this->rootName = $name;
		if (null !== $route) {
			$this->rootUri = $route;
		}

		$this->root = true;

		foreach($this->getChildren() as $child) {
			if (!$child->hasRoot()) {
				$child->addRoot();
			}
		}
	}

	public function hasRoot()
	{
		return $this->root;
	}

	public function getRootName()
	{
		return $this->rootName;
	}

	public function getRootUri()
	{
		return $this->rootUri;
	}

	public function setLost($name)
	{
		$this->lostName = $name;
	}

	public function getSeparator()
	{
		return $this->separator;
	}

	public function setSeparator($separator)
	{
		$this->separator = $separator;
	}

    /**
     * Add a child breadcrumb item to this breadcrumb
     *
     * @param mixed   $child    An BreadcrumbItem object or the controller of a new breadcrumb to create
     *
     * @return MenuItem The child menu item
     */
    public function addChild($child, $attributes = array(), $class = null)
    {
        if (!$child instanceof BreadcrumbItem) {
            $child = $this->createChild($child, $attributes = array(), $class);
        }

        $child->setParent($this);

        $this->children[$child->getRoute()] = $child;

        return $child;
    }

    public function getChildClass()
    {
    	return $this->childClass;
    }

    public function getChild($name)
    {
    	return isset($this->children[$name]) ? $this->children[$name] : null;
    }

    public function getChildren()
    {
    	return $this->children;
    }

    /**
     * Creates a new BreadcrumbItem to be the child of this breadcrumds
     *
     * @param string  $controller
     *
     * @return BreadcrumbItem
     */
    protected function createChild($route, $attributes = array(), $class = null)
    {
        if (null === $route) {
            throw new Exception("The route cannot be null");
        }

        if (null !== $class) {
        	return new $class($route, $attributes);
        }

        return new $this->childClass($route, $attributes);
    }

    /**
     * Sets renderer which will be used to render menu items.
     *
     * @param RendererInterface $renderer Renderer.
     */
    public function setRenderer(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function getRenderer()
    {
        if(null === $this->renderer) {
            $this->setRenderer(new ListRenderer());
        }

        return $this->renderer;
    }

    /**
     * Renders the menu tree by using the statically set renderer.
     *
     * @return string
     */
    public function render()
    {
        return $this->getRenderer()->render($this->getChild($this->currentRoute));
    }


    /**
     * Implements Countable
     */
    public function count()
    {
        return count($this->children);
    }

    /**
     * Implements IteratorAggregate
     */
    public function getIterator()
    {
        return new \ArrayObject($this->children);
    }

    /**
     * Implements ArrayAccess
     */
    public function offsetExists($id)
    {
        return isset($this->children[$id]);
    }

    /**
     * Implements ArrayAccess
     */
    public function offsetGet($id)
    {
        return $this->getChild($id);
    }

    /**
     * Implements ArrayAccess
     */
    public function offsetSet($id, $value)
    {
        return $this->addChild($id)->setLabel($value);
    }

    /**
     * Implements ArrayAccess
     */
    public function offsetUnset($id)
    {
        $this->removeChild($id);
    }
}