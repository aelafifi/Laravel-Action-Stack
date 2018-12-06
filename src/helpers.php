<?php

use ElMag\ActionStack\ActionStack;

if (!function_exists('action_stack')) {
    function action_stack(...$args)
    {
        return new ActionStack(...$args);
    }
}