<?php

namespace Tests\Weew\Commander\Mocks;

use Weew\Commander\Commander;

class FakeCommander extends Commander {
    public function getDefinitions() {
        return $this->definitions;
    }
}
