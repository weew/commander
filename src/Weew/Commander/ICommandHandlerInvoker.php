<?php

namespace Weew\Commander;

interface ICommandHandlerInvoker {
    /**
     * @param IDefinition $definition
     *
     * @return bool
     */
    function supports(IDefinition $definition);

    /**
     * @param IDefinition $definition
     * @param $command
     *
     * @return mixed
     */
    function invoke(IDefinition $definition, $command);
}
