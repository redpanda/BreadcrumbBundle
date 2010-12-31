<?php

namespace Bundle\BreadcrumbBundle\Twig;

use Bundle\BreadcrumbBundle\Twig\BreadcrumbsNode;

class BreadcrumbsTokenParser extends \Twig_TokenParser
{
    /**
     * @param \Twig_Token  $token
     * @return \Bundle\BreadcrumbBundle\Twig\BreadcrumbsNode
     * @throws \Twig_SyntaxError
     */
    public function parse(\Twig_Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();

        $value = $this->parser->getExpressionParser()->parseExpression();

        $stream->expect(\Twig_Token::BLOCK_END_TYPE);

        return new BreadcrumbsNode($value, $lineno, $this->getTag());
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return 'breadcrumbs';
    }
}