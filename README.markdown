BreadcrumbBundle
==========

This bundle is an EXPERIMENT it provides easy breadcrumbs integration and configuration for your Symfony2 project.

## Example

    <?php
    namespace Application\MyBundle\Breadcrumbs;
    use Bundle\BreadcrumbBundle\Breadcrumbs;
    use Symfony\Component\DependencyInjection\ContainerInterface;

    $breadcrumbs = new Breadcrumbs(ContainerInterface $container);
    $breadcrumbs->setRoot('Home', 'homepage');

	  $breadcrumbs
		    ->addChild('blog')
			      ->addPath('Blog', 'blog');

	  $breadcrumbs
		    ->addChild('blog_post')
			      ->addPath('Blog', 'blog');
			      ->addPath(null, 'blog_post', null, array('param_converter' => 'post');

	  echo $breadcrumbs->render();

The above breadcrumbs would render the following HTML:
    # for uri: http://myproject.com/blog with route: blog
    <ul>
        <li>
            <a href="/">Homepage</a>
        </li>
        <li>
            <a href="/blog">Blog</a>
        </li>
        <li>
            <a href="http://symfony-reloaded.org/">Symfony2</a>
        </li>
    </ul>
    
	# for uri: http://myproject.com/blog/1 with route: blog_post
    <ul>
        <li>
            <a href="/">Homepage</a>
        </li>
        <li>
            <a href="/blog">Blog</a>
        </li>
        <li>
            <a href="/blog/1">My first post</a>
        </li>
    </ul>

## Installation

Add BreadcrumbBundle to your src/Bundle dir

    $ git submodule add git://github.com/redpanda/BreadcrumbBundle.git src/Bundle/BreadcrumbBundle
    
## Initializing the bundle

To start using the bundle, initialize the bundle in your Kernel. This
file is usually located at `app/AppKernel`:

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Bundle\BreadcrumbBundle\BreadcrumbBundle(),
        );
    )

## Configuration

For `config.yml`:

    # to enable the twig view helper
    breadcrumbs.twig:   ~

    # to enable the PHP view helper
    breadcrumbs.templating: ~

and for `config.xml`:

    <!-- to enable the twig view helper -->
    <breadcrumbs:twig />

    <!-- to enable the PHP view helper -->
    <breadcrumbs:templating />
    
## Credits

This bundle was originally ported from sfOrmBreadcrumbsPlugin, a plugin for symfony1.
