<?php

namespace Weew\Commander\Invokers;

use Weew\Commander\ICommandHandlerInvoker;
use Weew\Commander\IDefinition;

class CallableHandlerInvoker implements ICommandHandlerInvoker {
    /**
     * @param IDefinition $definition
     *
     * @return bool
     */
    public function supports(IDefinition $definition) {
        return is_callable($definition->getHandler());
    }

    /**
     * @param IDefinition $definition
     * @param $command
     *
     * @return mixed
     */
    public function invoke(IDefinition $definition, $command) {
        return $this->invokeHandler($definition->getHandler(), $command);
    }

    /**
     * @param callable $handler
     * @param $command
     *
     * @return mixed
     */
    protected function invokeHandler(callable $handler, $command) {
        return $handler($command);
    }
}
