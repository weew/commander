<?php

namespace Weew\Commander;

interface ICommandHandler {
    /**
     * @param $command
     *
     * @return mixed
     */
    function handle($command);
}
