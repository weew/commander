<?php

namespace Weew\Commander;

class Definition implements IDefinition {
    /**
     * @var string
     */
    protected $type;

    /**
     * @var mixed
     */
    protected $handler;

    /**
     * Definition constructor.
     *
     * @param $type
     * @param $handler
     */
    public function __construct($type, $handler) {
        $this->setType($type);
        $this->setHandler($handler);
    }

    /**
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param $type
     *
     * @return string
     */
    public function setType($type) {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getHandler() {
        return $this->handler;
    }

    /**
     * @param $handler
     *
     * @return mixed
     */
    public function setHandler($handler) {
        $this->handler = $handler;
    }
}
