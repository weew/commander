<?php

namespace Tests\Weew\Commander\Invokers;

use PHPUnit_Framework_TestCase;
use Tests\Weew\Commander\Mocks\FakeCommandHandler;
use Weew\Commander\Definition;
use Weew\Commander\Exceptions\InvalidCommandHandlerException;
use Weew\Commander\Invokers\CommandHandlerInvoker;

class CommandHandlerInvokerTest extends PHPUnit_Framework_TestCase {
    public function test_supports() {
        $definition = new Definition('foo', 'bar');
        $invoker = new CommandHandlerInvoker();

        $this->assertFalse($invoker->supports($definition));
        $definition->setHandler(self::class);
        $this->assertFalse($invoker->supports($definition));
        $definition->setHandler(FakeCommandHandler::class);
        $this->assertTrue($invoker->supports($definition));
        $definition->setHandler(new FakeCommandHandler());
        $this->assertTrue($invoker->supports($definition));
    }

    public function test_invoke() {
        $invoker = new CommandHandlerInvoker();
        $definition = new Definition('foo', new FakeCommandHandler());
        $this->assertEquals('foo baz', $invoker->invoke($definition, 'baz'));
        $definition->setHandler(FakeCommandHandler::class);
        $this->assertEquals('foo bar', $invoker->invoke($definition, 'bar'));
    }

    public function test_invoke_with_exception_from_string() {
        $invoker = new CommandHandlerInvoker();
        $definition = new Definition('foo', self::class);
        $this->setExpectedException(InvalidCommandHandlerException::class);
        $invoker->invoke($definition, 'foo');
    }

    public function test_invoke_with_exception_from_object() {
        $invoker = new CommandHandlerInvoker();
        $definition = new Definition('foo', $this);
        $this->setExpectedException(InvalidCommandHandlerException::class);
        $invoker->invoke($definition, 'foo');
    }
}
