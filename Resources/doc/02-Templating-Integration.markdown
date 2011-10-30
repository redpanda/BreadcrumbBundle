Templating Integration
======================

### Create your breadcrumbs class

    // src/Application/MyBundle/Breadcrumbs/MainBreadcrumbs.php
    <?php
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

If you include the breadcrumbs configuration in your bundle (as shown above), you'll
need to include it as a resource in your base configuration:

    # app/config/config.xml
    ...

    <import resource="MyBundle/Resources/config/breadcrumbs.xml" />

### Access the breadcrumbs service

You can now access your breadcrumbs like any Symfony service:

    $breadcrumbs = $container->get('breadcrumbs.main');

From a controller, it's even easier:

    $breadcrumbs = $this['breadcrumbs.main']

The breadcrumbs is lazy loaded, and will construct its children the first time
you access it.

### Enable the breadcrumbs template helper

    # app/config/config.yml
    breadcrumbs.templating: ~

### Access the breadcrumbs from a template

You can render the breadcrumbs in a template:

    echo $view['breadcrumbs']->get('main')->render()