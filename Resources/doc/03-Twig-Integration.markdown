Twig Integration
================

### Create your breadcrumbs class

    <?php // src/Application/MyBundle/Breadcrumbs/MainBreadcrumbs.php
    
    namespace Application\MyBundle\Breadcrumbs;
    use Bundle\BreadcrumbBundle\Breadcrumbs;
    use Symfony\Component\DependencyInjection\ContainerInterface;
    
    class MainBreadcrumbs extends Breadcrumbs
    {
    	public function __construct(ContainerInterface $container)
    	{
	    	parent::__construct($container);
	    	
		    $this->setRoot('Home', 'homepage');
		
			$this->addChild('blog')
				->addPath('Blog', 'blog');
		
			$this->addChild('blog_post')
				->addPath('Blog', 'blog');
				->addPath(null, 'blog_post', null, array('param_converter' => 'post');
		}
	}

### Declare and configure your breadcrumbs service

Next, declare your breadcrumbs service class via configuration. An example in XML
is shown below:

    # src/Application/MyBundle/Resources/config/breadcrumbs.xml
    
    <?xml version="1.0" encoding="UTF-8"?>
    <container xmlns="http://www.symfony-project.org/schema/dic/services"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.symfony-project.org/schema/dic/services http://www.symfony-project.org/schema/dic/services/services-1.0.xsd">

    	<parameters>
        	<parameter key="breadcrumbs.main.class">Application\MyBundle\Breadcrumbs\MainBreadcrumbs</parameter>
    	</parameters>

    	<services>
        	<service id="breadcrumbs.main" class="%breadcrumbs.main.class%" shared="true">
            	<tag name="breadcrumbs" alias="main" />
            	<argument type="service" id="service_container" />
        	</service>
    	</services>
	</container>
    
### Enable the breadcrumbs twig helper

    # app/config/config.yml
    breadcrumbs.twig: ~

### Access the breadcrumbs from a template

	{% breadcrumbs 'main' %}
