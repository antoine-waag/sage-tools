<?php

declare (strict_types = 1);

namespace AntoineWaag\SageTools\Hooks;

abstract class AbstractHook
{
    abstract public function init(): void;
}
