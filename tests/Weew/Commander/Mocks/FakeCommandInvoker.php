<?php

namespace Tests\Weew\Commander\Mocks;

use Weew\Commander\ICommandHandlerInvoker;
use Weew\Commander\IDefinition;

class FakeCommandInvoker implements ICommandHandlerInvoker {
    /**
     * @param IDefinition $definition
     *
     * @return bool
     */
    public function supports(IDefinition $definition) {
        return true;
    }

    /**
     * @param IDefinition $definition
     * @param $command
     *
     * @return mixed
     */
    public function invoke(IDefinition $definition, $command) {
        return 'foo';
    }
}
