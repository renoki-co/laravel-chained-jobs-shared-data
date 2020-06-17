<?php

namespace RenokiCo\ChainedJobsSharedData;

use Illuminate\Foundation\Bus\PendingChain as BasePendingChain;
use Illuminate\Foundation\Bus\PendingDispatch;

class PendingChain extends BasePendingChain
{
    /**
     * The data that will be shared across the jobs.
     *
     * @var mixed
     */
    public $sharedData;

    /**
     * Create a new PendingChain instance.
     *
     * @param  mixed  $job
     * @param  array  $chain
     * @param  mixed  $sharedData
     * @return void
     */
    public function __construct($job, $chain, $sharedData = null)
    {
        $this->job = $job;
        $this->chain = $chain;
        $this->sharedData = $sharedData;
    }

    /**
     * Dispatch the job with the given arguments.
     *
     * @return \Illuminate\Foundation\Bus\PendingDispatch
     */
    public function dispatch()
    {
        if (is_string($this->job)) {
            $firstJob = (new $this->job(...func_get_args()))
                ->sharedData($this->sharedData);
        } elseif ($this->job instanceof Closure) {
            $firstJob = CallQueuedClosure::create($this->job);
        } else {
            $firstJob = $this->job;
        }

        return (new PendingDispatch($firstJob))
            ->chain($this->chain);
    }
}
