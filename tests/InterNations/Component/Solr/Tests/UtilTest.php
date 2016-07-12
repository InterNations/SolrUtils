<?php
namespace InterNations\Component\Solr\Tests;

use InterNations\Component\Solr\ExpressionInterface;
use InterNations\Component\Solr\Util;
use PHPUnit_Framework_TestCase as TestCase;

class TestExpression implements ExpressionInterface
{
    public function isEqual($expr)
    {
        return true;
    }

    public function __toString()
    {
        return '(fixed)';
    }
}

class UtilTest extends TestCase
{
    /**
     * @see http://lucene.apache.org/core/4_5_0/queryparser/org/apache/lucene/queryparser/classic/package-summary.html
     * @var string
     */
    private static $charList = '+ - && || ! ( ) { } [ ] ^ " ~ * ? : \ /';

    public function getChars()
    {
        $list = preg_split('//', static::$charList);
        $list = array_map('trim', $list);
        $list = array_filter($list);
        array_unique($list);

        return array_map(array($this, 'wrap'), $list);
    }

    public function wrap($char)
    {
        return array($char);
    }

    public function getEscapingStrings()
    {
        return array(
            array('\\foo\\bar"', '\\\\foo\\\\bar\\"'),
        );
    }

    /** @dataProvider getChars */
    public function testEscaping($char)
    {
        $this->assertSame('\\' . $char, Util::escape($char));
    }

    /** @dataProvider getChars */
    public function testQuoting($char)
    {
        $this->assertSame('"\\' . $char . '"', Util::quote($char));
    }

    /** @dataProvider getChars */
    public function testSanitizing($char)
    {
        $this->assertSame('"\\' . $char . '"', Util::sanitize($char));
    }

    public function testSanitize_Int()
    {
        $this->assertSame('1', Util::sanitize(1));
    }

    public function testSanitize_Empty()
    {
        $this->assertSame('', Util::sanitize(''));
        $this->assertSame('', Util::sanitize(null));
    }

    public function testSanitize_Float()
    {
        $this->assertSame('1000.00000000000000', Util::sanitize(1000.0));
    }

    public function testSanitize_NumericString()
    {
        $this->assertSame('"\+1122"', Util::sanitize('+1122'));
        $this->assertSame('"\-1122"', Util::sanitize('-1122'));
    }

    public function testSanitizing_ScientificNotationDoesNotIntroduceMinusChar()
    {
        $this->assertSame('0.00002100000000', Util::sanitize(2.1E-5));
    }

    /** @dataProvider getEscapingStrings */
    public function testVariousEscaping($input, $output)
    {
        $this->assertSame($output, Util::escape($input));
    }

    public function testExpressionsAreNotTouched()
    {
        $expression = new TestExpression();
        $this->assertSame($expression, Util::escape($expression));
        $this->assertSame($expression, Util::sanitize($expression));
        $this->assertSame($expression, Util::quote($expression));
    }
}
