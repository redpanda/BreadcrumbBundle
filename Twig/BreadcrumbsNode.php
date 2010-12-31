<?php

namespace Bundle\BreadcrumbBundle\Twig;

class BreadcrumbsNode extends \Twig_Node
{
    /**
     * @param \Twig_NodeInterface $value
     * @param \Twig_NodeInterface $depth (optional)
     * @param integer $lineno
     * @param string $tag (optional)
     * @return void
     */
    public function __construct(\Twig_NodeInterface $value, $lineno, $tag = null)
    {
        parent::__construct(array('value' => $value), array(), $lineno, $tag);
    }

    /**
     * @param \Twig_Compiler $compiler
     * @return void
     */
    public function compile($compiler)
    {
        $compiler->addDebugInfo($this);

        $compiler
            ->write("echo \$this->env->getExtension('breadcrumbs')->get(")
            ->subcompile($this->getNode('value'))
            ->raw(")->render(");

        $compiler->raw(");\n");
    }
}

