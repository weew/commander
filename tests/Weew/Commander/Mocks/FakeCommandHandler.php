<?php

namespace Tests\Weew\Commander\Mocks;

use Weew\Commander\ICommandHandler;

class FakeCommandHandler implements ICommandHandler {
    public function handle($command) {
        return 'foo ' . $command;
    }
}
