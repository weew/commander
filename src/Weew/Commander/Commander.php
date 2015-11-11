<?php

namespace Weew\Commander;

use Weew\Commander\Exceptions\InvalidCommandException;
use Weew\Commander\Exceptions\UnhandledCommandException;
use Weew\Commander\Exceptions\UnsupportedCommandHandlerException;
use Weew\Commander\Invokers\CallableHandlerInvoker;
use Weew\Commander\Invokers\CommandHandlerInvoker;

class Commander {
    /**
     * @var ICommandHandlerInvoker[]
     */
    protected $invokers;

    /**
     * @var IDefinition[]
     */
    protected $definitions = [];

    /**
     * Commander constructor.
     *
     * @param ICommandHandlerInvoker[]|null $invokers
     */
    public function __construct(array $invokers = null) {
        if ( ! is_array($invokers)) {
            $invokers = $this->createDefaultInvokers();
        }

        $this->setCommandHandlerInvokers($invokers);
    }

    /**
     * @param $type
     * @param $handler
     *
     * @return $this
     */
    public function register($type, $handler) {
        $this->addDefinition(
            $this->createDefinition($type, $handler)
        );

        return $this;
    }

    /**
     * @param $command
     *
     * @return mixed
     * @throws UnhandledCommandException
     */
    public function dispatch($command) {
        $type = $this->getCommandType($command);
        $definition = $this->getDefinition($type);

        if ( ! $definition instanceof IDefinition) {
            throw new UnhandledCommandException(
                s('Command %s could not be dispatched. Missing command handler.',
                    get_type($command))
            );
        }

        return $this->invokeDefinition($definition, $command);
    }

    /**
     * @return ICommandHandlerInvoker[]
     */
    public function getCommandHandlerInvokers() {
        return $this->invokers;
    }

    /**
     * @param ICommandHandlerInvoker[] $invokers
     */
    public function setCommandHandlerInvokers(array $invokers) {
        $this->invokers = [];

        foreach ($invokers as $invoker) {
            $this->addCommandHandlerInvoker($invoker);
        }
    }

    /**
     * @param ICommandHandlerInvoker $invoker
     */
    public function addCommandHandlerInvoker(ICommandHandlerInvoker $invoker) {
        $this->invokers[] = $invoker;
    }

    /**
     * @param $type
     *
     * @return IDefinition|null
     */
    protected function getDefinition($type) {
        return array_get($this->definitions, $type);
    }

    /**
     * @param $type
     * @param $handler
     *
     * @return Definition
     */
    protected function createDefinition($type, $handler) {
        return new Definition($type, $handler);
    }

    /**
     * @param IDefinition $definition
     */
    protected function addDefinition(IDefinition $definition) {
        $this->definitions[$definition->getType()] = $definition;
    }

    /**
     * @param $command
     *
     * @return string
     * @throws InvalidCommandException
     */
    protected function getCommandType($command) {
        if (is_object($command)) {
            return get_class($command);
        }

        throw new InvalidCommandException(
            s('Command must be an object, %s received.', get_type($command))
        );
    }

    /**
     * @param IDefinition $definition
     * @param $command
     *
     * @return mixed
     * @throws UnsupportedCommandHandlerException
     */
    protected function invokeDefinition(IDefinition $definition, $command) {
        foreach ($this->invokers as $invoker) {
            if ($invoker->supports($definition)) {
                return $invoker->invoke($definition, $command);
            }
        }

        throw new UnsupportedCommandHandlerException(
            s('Command handlers of type %s are not supported.',
                get_type($definition->getHandler()))
        );
    }

    /**
     * @return ICommandHandlerInvoker[]
     */
    protected function createDefaultInvokers() {
        return [
            new CallableHandlerInvoker(),
            new CommandHandlerInvoker(),
        ];
    }
}
