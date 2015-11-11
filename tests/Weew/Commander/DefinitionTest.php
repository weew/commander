<?php

namespace Tests\Weew\Commander;

use PHPUnit_Framework_TestCase;
use Weew\Commander\Definition;

class DefinitionTest extends PHPUnit_Framework_TestCase {
    public function test_getters_and_setters() {
        $definition = new Definition('foo', 'bar');
        $this->assertEquals('foo', $definition->getType());
        $this->assertEquals('bar', $definition->getHandler());
        $definition->setType('baz');
        $this->assertEquals('baz', $definition->getType());
        $definition->setHandler('foo');
        $this->assertEquals('foo', $definition->getHandler());
    }
}
