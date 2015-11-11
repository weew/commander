<?php

namespace Tests\Weew\Commander;

use PHPUnit_Framework_TestCase;
use Tests\Weew\Commander\Mocks\FakeCommand;
use Tests\Weew\Commander\Mocks\FakeCommander;
use Tests\Weew\Commander\Mocks\FakeCommandHandler;
use Tests\Weew\Commander\Mocks\FakeCommandInvoker;
use Weew\Commander\Commander;
use Weew\Commander\Exceptions\InvalidCommandException;
use Weew\Commander\Exceptions\UnhandledCommandException;
use Weew\Commander\Exceptions\UnsupportedCommandHandlerException;
use Weew\Commander\IDefinition;

class CommanderTest extends PHPUnit_Framework_TestCase {
    public function test_get_and_set_command_handler_invokers() {
        $invoker = new FakeCommandInvoker();
        $commander = new Commander([$invoker]);
        $this->assertEquals([$invoker], $commander->getCommandHandlerInvokers());
        $commander->addCommandHandlerInvoker($invoker);
        $this->assertEquals([$invoker, $invoker], $commander->getCommandHandlerInvokers());
    }

    public function test_register() {
        $commander = new FakeCommander();
        $cmndr = $commander->register(FakeCommand::class, FakeCommandHandler::class);
        $this->assertTrue($cmndr === $commander);
        $this->assertEquals(1, count($commander->getDefinitions()));
        $definitions = $commander->getDefinitions();
        $definition = array_pop($definitions);
        $this->assertTrue($definition instanceof IDefinition);
        $this->assertEquals(FakeCommand::class, $definition->getType());
        $this->assertEquals(FakeCommandHandler::class, $definition->getHandler());
    }

    public function test_dispatch_with_invalid_command() {
        $commander = new Commander();
        $this->setExpectedException(InvalidCommandException::class);
        $commander->dispatch(FakeCommand::class);
    }

    public function test_dispatch_without_handler() {
        $commander = new Commander();
        $this->setExpectedException(UnhandledCommandException::class);
        $commander->dispatch($this);
    }

    public function test_dispatch_with_handler() {
        $commander = new Commander();
        $commander->register(FakeCommand::class, FakeCommandHandler::class);
        $this->assertEquals('foo yolo', $commander->dispatch(new FakeCommand()));
    }

    public function test_dispatch_with_unsupported_handler() {
        $commander = new Commander();
        $commander->register(FakeCommand::class, 'yolo');
        $this->setExpectedException(UnsupportedCommandHandlerException::class);
        $commander->dispatch(new FakeCommand());
    }
}
