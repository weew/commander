<?php

namespace Tests\Weew\Commander\Invokers;

use PHPUnit_Framework_TestCase;
use Weew\Commander\Definition;
use Weew\Commander\Invokers\CallableHandlerInvoker;

class CallableHandlerInvokerTest extends PHPUnit_Framework_TestCase {
    public function test_supports() {
        $definition = new Definition('foo', self::class);
        $invoker = new CallableHandlerInvoker();
        $this->assertFalse($invoker->supports($definition));
        $definition->setHandler(function() {});
        $this->assertTrue($invoker->supports($definition));
        $definition->setHandler([$this, 'test_supports']);
        $this->assertTrue($invoker->supports($definition));
    }

    public function test_invoke() {
        $invoker = new CallableHandlerInvoker();
        $definition = new Definition('foo', function($command) {
            return $command;
        });
        $this->assertEquals('baz', $invoker->invoke($definition, 'baz'));
    }
}
