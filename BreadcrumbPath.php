<?php

namespace Bundle\BreadcrumbBundle;

use Symfony\Component\Routing\Router;

class BreadcrumbPath
{
    /**
     * Properties on this breadcrumb link
     */
	protected
		$name       = null, // the name of the breadcrumb link
		$route      = null, // the route of the breadcrumb link
		$attributes = null, // an array of attributes for the li
		$options    = null; // an array of options
		
    /**
     * Metadata on this breadcrumb item
     */
	protected
		$parent     = null; // parent BreadcrumbItem

    /**
     * Class constructor
     * 
     * @param string $name       The name of this link
     * @param string $route      The route for this link to use.
     * @param array  $attributes Attributes to place on the li tag of this breadcrumb link
     */
	public function __construct($name, $route, $attributes = array(), $options = array())
	{
		$this->name = $name;
		$this->route = $route;
		$this->attributes = $attributes;
		$this->options = $options;
	}
	
    /**
     * @return string
     */
	public function getName()
	{
		return $this->name;
	}
	
	public function setName($name)
	{
		$this->name = $name;
	}

    /**
     * @return string
     */
	public function getRoute()
	{
		return $this->route;
	}
	
    public function getParamConverter()
    { 
    	$paramConverter = $this->getOption('param_converter');
    	
    	return $this->get('request')->attributes->get($paramConverter);
    }
	
    /**
     * @return array
     */
	public function getAttributes()
	{
		return $this->attributes;
	}
	
    /**
     * @param  string $id     The id of the attribute to return
     * 
     * @return mixed
     */
	public function getAttribute($id)
	{
		if ($this->hasAttribute($id)) {
			return $this->attributes[$id];
		}
	}
	
	/**
	 * @param  string $id     The id of the attribute
	 * 
	 * @return boolean
	 */
	public function hasAttribute($id)
	{
		return isset($this->attributes[$id]);
	}
	
	public function setAttribute($id, $value)
	{
		$this->attributes[$id] = $value;
	}

	/**
     * @return array
     */
	public function getOptions()
	{
		return $this->options;
	}
	
    /**
     * @param  string $id     The id of the option to return
     * 
     * @return mixed
     */
	public function getOption($id)
	{
		if ($this->hasOption($id)) {
			return $this->options[$id];
		}
	}
	
	/**
	 * @param  string $id     The id of the option
	 * 
	 * @return boolean
	 */
	public function hasOption($id)
	{
		return isset($this->options[$id]);
	}
	
	public function setOptions($id, $value)
	{
		$this->options[$id] = $value;
	}
	
	public function setParent($parent)
	{
		$this->parent = $parent;
	}
	
	public function getParent()
	{
		return $this->parent;
	}
    
    public function get($id)
    {
    	return $this->getParent()->getParent()->getContainer()->get($id);
    }
	
    /**
     * Renders the anchor tag for this breadcrumb link.
     *
     * If no route is specified, the name will be output.
     *
     * @return string
     */
    public function renderLink()
    {
        $name = $this->renderName();
        $route = $this->getRoute();
        
        if (!$route) {
            return $name;
        }

        $router = $this->get('router');
        
        // if a param converter is defined
        if ($this->hasOption('param_converter')) {
        	$request = $this->get('request');
			
        	$object = $this->getParamConverter();
        	
        	$params = $request->attributes->all();
        	unset($params['_controller']);
        	unset($params['_route']);
        	unset($params[$this->getOption('param_converter')]);

        	return sprintf('<a href="%s">%s</a>', $router->generate($route, $params), $object);
        }

        return sprintf('<a href="%s">%s</a>', $router->generate($route), $name);
    }
    
    /**
     * Renders the name of this breadcrumb link
     *
     * @return string
     */
    public function renderName()
    {
    	if ($this->hasOption('param_converter') && null === $this->getName()) {
    		$name = $this->getParamConverter();
    	}
    	
        return $this->getName();
    }
}