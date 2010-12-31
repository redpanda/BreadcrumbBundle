<?php

namespace Bundle\BreadcrumbBundle\Renderer;
use Bundle\BreadcrumbBundle\BreadcrumbItem;

interface RendererInterface
{
  /**
   * Renders breadcrumbs tree.
   *
   * @param BreadcrumbItem    $item         Breadcrumb item
   *
   * @return string
   */
  public function render(BreadcrumbItem $item);
}
