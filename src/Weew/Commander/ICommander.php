<?php

namespace Weew\Commander;

use Weew\Commander\Exceptions\UnhandledCommandException;

interface ICommander {
    /**
     * @param $type
     * @param $handler
     *
     * @return ICommander
     */
    function register($type, $handler);

    /**
     * @param $command
     *
     * @return mixed
     * @throws UnhandledCommandException
     */
    function dispatch($command);
}
