<?php

namespace Tests\Weew\Commander\Mocks;

class FakeCommandHandler {
    public function handle($command) {
        return 'foo ' . $command;
    }
}
