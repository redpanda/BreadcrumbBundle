BreadcrumbBundle
================

This bundle is an EXPERIMENT it provides easy breadcrumbs integration and configuration for your Symfony2 project.

## Reference Manual

The bulk of the documentation can be found in the `Resources/doc` directory.

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
    breadcrumbs.twig: ~

    # to enable the PHP view helper
    breadcrumbs.templating: ~

and for `config.xml`:

    <!-- to enable the twig view helper -->
    <breadcrumbs:twig />

    <!-- to enable the PHP view helper -->
    <breadcrumbs:templating />

## Credits

This bundle was originally ported from sfOrmBreadcrumbsPlugin, a plugin for symfony1.
