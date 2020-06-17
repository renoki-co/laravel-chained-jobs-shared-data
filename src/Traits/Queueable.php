<?php

namespace RenokiCo\ChainedJobsSharedData\Traits;

use Illuminate\Bus\Queueable as BaseQueueable;

trait Queueable
{
    use BaseQueueable;

    /**
     * Dispatch the next job on the chain.
     *
     * @return void
     */
    public function dispatchNextJobInChain()
    {
        if (! empty($this->chained)) {
            dispatch(tap(unserialize(array_shift($this->chained)), function ($next) {
                $next->chained = $this->chained;

                $next->onConnection($next->connection ?: $this->chainConnection);
                $next->onQueue($next->queue ?: $this->chainQueue);
                $next->sharedData($this->sharedData);

                $next->chainConnection = $this->chainConnection;
                $next->chainQueue = $this->chainQueue;
            }));
        }
    }
}
