<?php

namespace MichaelRubel\ValueObjects\Concerns;

use Closure;

trait HandlesCallbacks
{
    /**
     * Callback to hook into parent construct
     * before any other call is performed.
     *
     * @var Closure
     */
    protected Closure $before;

    /**
     * Set the "before" callback.
     *
     * @param  Closure  $callback
     *
     * @return void
     */
    protected function beforeParentCalls(Closure $callback): void
    {
        $this->before = $callback;
    }
}
