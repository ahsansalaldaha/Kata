<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mockery;
use Mockery\MockInterface;
use Illuminate\Support\Carbon;
use App\Interfaces\CurrentAvailabilityInterface;
use App\Interfaces\NextAvailabilityInterface;
use App\Interfaces\AvailabilityInterface;
use App\Services\ShopTimingService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;

class ShopTimingServiceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function mockDependencies()
    {
    }

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call("db:seed");
        $this->mockDependencies();
    }

    public function test_if_is_open_currently_is_working()
    {
        $timerService = $this->app->make(CurrentAvailabilityInterface::class);
        $this->assertInstanceOf(ShopTimingService::class, $timerService);

        Carbon::setTestNow(Carbon::create(2022, 3, 14, 8, 0, 0));

        $is_open =  $timerService->isOpen();
        $this->assertEquals(true, $is_open);
    }

    public function test_if_is_open_at_specific_date_is_working()
    {
        $timerService = $this->app->make(AvailabilityInterface::class);
        $this->assertInstanceOf(ShopTimingService::class, $timerService);

        $is_open =  $timerService->isOpenOn(Carbon::create(2022, 3, 14, 8, 0, 0));
        $this->assertEquals(true, $is_open);

        $is_open =  $timerService->isOpenOn(Carbon::create(2022, 3, 14, 17, 0, 0));
        $this->assertEquals(false, $is_open);
    }

    public function test_if_is_open_on_break_at_specific_date_is_working()
    {
        $timerService = $this->app->make(AvailabilityInterface::class);
        $this->assertInstanceOf(ShopTimingService::class, $timerService);

        $is_open =  $timerService->isOpenOn(Carbon::create(2022, 3, 14, 11, 59, 0));
        $this->assertEquals(true, $is_open);

        $is_open =  $timerService->isOpenOn(Carbon::create(2022, 3, 14, 12, 0, 0));
        $this->assertEquals(false, $is_open);

        $is_open =  $timerService->isOpenOn(Carbon::create(2022, 3, 14, 12, 1, 0));
        $this->assertEquals(false, $is_open);

        $is_open =  $timerService->isOpenOn(Carbon::create(2022, 3, 14, 12, 45, 0));
        $this->assertEquals(false, $is_open);

        $is_open =  $timerService->isOpenOn(Carbon::create(2022, 3, 14, 12, 46, 0));
        $this->assertEquals(true, $is_open);
    }

    public function test_if_nearest_availability_currently_is_working()
    {
        $timerService = $this->app->make(NextAvailabilityInterface::class);
        $this->assertInstanceOf(ShopTimingService::class, $timerService);

        // If shift is starting in few hours
        Carbon::setTestNow(Carbon::create(2022, 3, 14, 7, 59, 0));
        $nearest_open =  $timerService->nextAvailability();
        $this->assertEquals(Carbon::create(2022, 3, 14, 8, 0, 0), $nearest_open);

        // If its break time
        Carbon::setTestNow(Carbon::create(2022, 3, 14, 12, 40, 0));
        $nearest_open =  $timerService->nextAvailability();
        $this->assertEquals(Carbon::create(2022, 3, 14, 12, 45, 0), $nearest_open);

        // If shop is already open
        Carbon::setTestNow(Carbon::create(2022, 3, 14, 8, 0, 0));
        $nearest_open =  $timerService->nextAvailability();
        $this->assertNull($nearest_open);

        // If shop will open next day
        Carbon::setTestNow(Carbon::create(2022, 3, 14, 17, 0, 0));
        $nearest_open =  $timerService->nextAvailability();
        $this->assertEquals(Carbon::create(2022, 3, 16, 8, 0, 0), $nearest_open);

        // If shop will open next day but its not applicable saturday
        Carbon::setTestNow(Carbon::create(2022, 3, 25, 17, 0, 0));
        $nearest_open =  $timerService->nextAvailability();
        $this->assertEquals(Carbon::create(2022, 3, 28, 8, 0, 0), $nearest_open);

        // If shop will today but its first saturday
        Carbon::setTestNow(Carbon::create(2022, 3, 19, 6, 0, 0));
        $nearest_open =  $timerService->nextAvailability();
        $this->assertEquals(Carbon::create(2022, 3, 19, 8, 0, 0), $nearest_open);
    }
}
