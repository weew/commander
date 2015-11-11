<?php

namespace Weew\Commander\Invokers;

use Weew\Commander\Exceptions\InvalidCommandHandlerException;
use Weew\Commander\ICommandHandler;
use Weew\Commander\ICommandHandlerInvoker;
use Weew\Commander\IDefinition;

class CommandHandlerInvoker implements ICommandHandlerInvoker {
    /**
     * @param IDefinition $definition
     *
     * @return bool
     */
    public function supports(IDefinition $definition) {
        $handler = $definition->getHandler();

        if ($this->isValidHandler($handler)) {
            return true;
        }

        if ($this->isValidHandlerClass($handler)) {
            return true;
        }

        return false;
    }

    /**
     * @param IDefinition $definition
     * @param $command
     *
     * @return mixed
     * @throws InvalidCommandHandlerException
     */
    public function invoke(IDefinition $definition, $command) {
        $handler = $definition->getHandler();

        if ($this->isValidHandlerClass($handler)) {
            $handler = $this->createHandler($handler);
        }

        if ($this->isValidHandler($handler)) {
            return $this->invokeHandler($handler, $command);
        }

        throw new InvalidCommandHandlerException(
            s('%s must implement interface %s to be a valid command handler.',
                is_string($handler) ? $handler : get_type($handler),
                ICommandHandler::class)
        );
    }

    /**
     * @param $class
     *
     * @return ICommandHandler
     */
    protected function createHandler($class) {
        return new $class();
    }

    /**
     * @param ICommandHandler $handler
     * @param $command
     *
     * @return mixed
     */
    protected function invokeHandler(ICommandHandler $handler, $command) {
        return $handler->handle($command);
    }

    /**
     * @param $handler
     *
     * @return bool
     */
    protected function isValidHandlerClass($handler) {
        return is_string($handler) &&
            class_exists($handler) &&
            in_array(ICommandHandler::class, class_implements($handler));
    }

    /**
     * @param $handler
     *
     * @return bool
     */
    protected function isValidHandler($handler) {
        return $handler instanceof ICommandHandler;
    }
}
