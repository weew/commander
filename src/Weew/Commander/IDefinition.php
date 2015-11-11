<?php

namespace Weew\Commander;

interface IDefinition {
    /**
     * @return string
     */
    function getType();

    /**
     * @param $type
     *
     * @return string
     */
    function setType($type);

    /**
     * @return mixed
     */
    function getHandler();

    /**
     * @param $handler
     *
     * @return mixed
     */
    function setHandler($handler);
}
