<?php

namespace ElMag\ActionStack;

use Closure;
use Exception;

class ActionStack
{
    protected $args;
    protected $go_next = true;
    protected $ret;

    public function __construct(...$args)
    {
        $this->args = $args;
    }

    /**
     * @param $callback
     * @param null $method
     * @return static
     * @throws Exception
     */
    public function next($callback, $method = null)
    {
        if (!$this->go_next) {
            return $this;
        }

        if (is_callable($callback)) {
            $ret = call_user_func($callback, ...$this->args);
        } elseif ($method !== null) {
            $ret = call_user_func([$callback, $method], ...$this->args);
        } else {
            throw new Exception('Wrong parameters.');
        }

        if ($ret instanceof Exception) {
            throw $ret;
        }

        if ($ret === null) {
            return $this;
        }

        $this->ret = $ret;
        $this->go_next = false;

        return $this;
    }

    public function getReturn()
    {
        return $this->ret;
    }
}