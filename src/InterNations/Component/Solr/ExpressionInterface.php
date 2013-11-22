<?php
namespace InterNations\Component\Solr;

interface ExpressionInterface
{
    /**
     * Returns true if given expression is equal
     *
     * @param string $expr
     * @return boolean
     */
    public function isEqual($expr);

    /**
     * Return string representation
     *
     * @return string
     */
    public function __toString();
}
