<?php

namespace Bundle\BreadcrumbBundle;

class BreadcrumbItem implements \ArrayAccess, \Countable, \IteratorAggregate
{
    /**
     * Properties on this breadcrumb item
     */
    protected
    	$route            = null,    // the route of this breadcrumb item
    	$attributes       = null,    // an array of attributes for the ul
		$childClass       = null;    // the child class of this breadcrumb item
        
    /**
     * Metadata on this breadcrumb item
     */
	protected
		$parent           = null,    // parent Breadcrumbs
    	$children         = array(), // an array of BreadcrumPath children
    	$root             = false;   // whether or not this breadcrumb item have a root
    	
    /**
     * The renderer used to render this breadcrumb item 
     * 
     * @var RendererInterface
     */
    protected $renderer   = null;
    
    /**
     * Class constructor
     * 
     * @param string $route
     * @param array  $attributes
     * @param string $childClass
     */
    public function __construct($route, $attributes = array(), $childClass = 'Bundle\BreadcrumbBundle\BreadcrumbPath')
    {
        $this->route = (string) $route;
        $this->attributes = $attributes;
        $this->childClass = $childClass;
    }
    
    public function hasRoot()
    {
    	return $this->root;
    }
    
    public function addRoot()
    {
    	if (!$this->hasRoot()) {
	    	$path = $this->createPath($this->getParent()->getRootName(), $this->getParent()->getRootUri());
	    	
	    	$childrenTemp = array();
	    	$childrenTemp[] = $path;
	    	foreach($this->getChildren() as $child)
	    	{
	    		$childrenTemp[] = $child;
	    	}
	    	
	    	$this->root = true;
	    	$this->children = $childrenTemp;
    	}
    }
    
    public function addPath($name, $route, $attributes = array(), $options = array(), $class = null)
    {
    	$path = $this->createPath($name, $route, $attributes, $options, $class = null);
    	
        $this->children[] = $path;

        return $this;
    }
    
    protected function createPath($name, $route, $attributes = array(), $options = array(), $class = null)
    {
    	if (null === $class) {
    		$path = new $this->childClass($name, $route, $attributes, $options);
    	} else {
    		$path = new $class($name, $route, $attributes, $options);
    	}
    	
    	$path->setParent($this);
    	
    	return $path;
    }
    
    public function getAttributes()
    {
        return $this->attributes;
    }
    
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
        
        return $this;
    }
    
    public function setAttribute($id, $value)
    {
        $this->attributes[$id] = $value;
        
        return $this;
    }
    
    public function getChildren()
    {
    	return $this->children;
    }
    
    public function hasChildren()
    {
    	return empty($this->chidlren);
    }
    
    public function getRoute()
    {
    	return $this->route;
    }
    
    public function getParent()
    {
    	return $this->parent;
    }
    
    public function setParent($parent)
    {
    	$this->parent = $parent;
    	
    	if ($this->parent->hasRoot()) {
    		$this->addPath($this->parent->getRootName(), $this->parent->getRootUri());
    		
    		$this->root = true;
    	}
    }
    
    public function getChild($name)
    {
    	return isset($this->children[$name]) ? $this->children[$name] : null;
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
    public function offsetGet($name)
    {
        return $this->getChild($name);
    }

    /**
     * Implements ArrayAccess
     */
    public function offsetSet($id, $value)
    {
        return $this->addChild($id)->setName($value);
    }

    /**
     * Implements ArrayAccess
     */
    public function offsetUnset($id)
    {
        $this->removeChild($id);
    }
}