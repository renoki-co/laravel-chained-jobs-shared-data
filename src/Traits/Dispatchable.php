<?php

namespace RenokiCo\ChainedJobsSharedData\Traits;

use Illuminate\Foundation\Bus\Dispatchable as BaseDispatchable;
use RenokiCo\ChainedJobsSharedData\PendingChain;

trait Dispatchable
{
    use BaseDispatchable;

    /**
     * The data that was shared between previous jobs (if any).
     *
     * @var mixed
     */
    public $sharedData;

    /**
     * Set the jobs that should run if this job is successful.
     *
     * @param  array  $chain
     * @param  mixed  $sharedData
     * @return \Illuminate\Foundation\Bus\PendingChain
     */
    public static function withChain($chain, $sharedData = null)
    {
        return new PendingChain(static::class, $chain, $sharedData);
    }

    /**
     * Pass the shared data.
     *
     * @param  mixed  $sharedData
     * @return $this
     */
    public function sharedData($sharedData)
    {
        $this->sharedData = $sharedData;

        return $this;
    }
}
