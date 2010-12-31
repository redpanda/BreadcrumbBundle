<?php

namespace Bundle\BreadcrumbBundle\Tests;
use Bundle\BreadcrumbBundle\Breadcrumbs;

class BreadcrumbsTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateBreadcrumbsWithEmptyParameter()
    {
        $breadcrumbs = new Breadcrumbs();
        $this->assertTrue($breadcrumbs instanceof Breadcrumbs);
    }

    public function testCreateBreadcrumbsWithItemClass()
    {
        $childClass = 'Bundle\BreadcrumbsBundle\OtherBreadcrumbItem';
        $breadcrumbs = new Breadcrumbs(null, $childClass);
        $this->assertEquals($childClass, $breadcrumbs->getChildClass());
    }
}