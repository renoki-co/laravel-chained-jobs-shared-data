<?php

namespace RenokiCo\ChainedJobsSharedData\Test;

use Illuminate\Contracts\Queue\ShouldQueue;
use RenokiCo\ChainedJobsSharedData\Traits\Dispatchable;
use RenokiCo\ChainedJobsSharedData\Traits\Queueable;

class JobsTest extends TestCase
{
    public function test_chain()
    {
        FirstJob::withChain([
            new SecondJob,
            new ThirdJob,
        ], ['var1' => 1])->dispatch();

        $this->assertEquals(['var1' => 1], FirstJob::$usedSharedData);
        $this->assertEquals(['var1' => 1], SecondJob::$usedSharedData);
        $this->assertEquals(['var1' => 1], ThirdJob::$usedSharedData);
    }

    public function test_chain_and_modify_shared_data()
    {
        FirstJob::withChain([
            new SecondJob,
            new JobThatModifiesSharedData,
            new ThirdJob,
        ], ['var1' => 1])->dispatch();

        $this->assertEquals(['var1' => 1], JobThatModifiesSharedData::$usedSharedData);
        $this->assertEquals(['var1' => 1], FirstJob::$usedSharedData);
        $this->assertEquals(['var1' => 1], SecondJob::$usedSharedData);
        $this->assertEquals(['var1' => 1, 'var2' => 2], ThirdJob::$usedSharedData);
    }

    public function test_chain_and_modify_shared_data_if_called_first()
    {
        JobThatModifiesSharedData::withChain([
            new FirstJob,
            new SecondJob,
            new ThirdJob,
        ], ['var1' => 1])->dispatch();

        $this->assertEquals(['var1' => 1], JobThatModifiesSharedData::$usedSharedData);
        $this->assertEquals(['var1' => 1, 'var2' => 2], FirstJob::$usedSharedData);
        $this->assertEquals(['var1' => 1, 'var2' => 2], SecondJob::$usedSharedData);
        $this->assertEquals(['var1' => 1, 'var2' => 2], ThirdJob::$usedSharedData);
    }
}

class FirstJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public static $ran = false;
    public static $usedSharedData = null;

    public function handle()
    {
        static::$ran = true;
        static::$usedSharedData = $this->sharedData;
    }
}

class SecondJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public static $ran = false;
    public static $usedSharedData = null;

    public function handle()
    {
        static::$ran = true;
        static::$usedSharedData = $this->sharedData;
    }
}

class ThirdJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public static $ran = false;
    public static $usedSharedData = null;

    public function handle()
    {
        static::$ran = true;
        static::$usedSharedData = $this->sharedData;
    }
}

class JobThatModifiesSharedData implements ShouldQueue
{
    use Dispatchable, Queueable;

    public static $ran = false;
    public static $usedSharedData = null;

    public function handle()
    {
        static::$ran = true;
        static::$usedSharedData = $this->sharedData;

        $this->sharedData['var2'] = 2;
    }
}
