<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class APITest extends TestCase
{
    use DatabaseMigrations;
    /**
     * Is Open Now api testing.
     *
     * @return void
     */
    public function test_that_is_open_now_is_working()
    {
        $response = $this->get('/api/is-open-now');
        $response->assertStatus(200);
    }

    /**
     * Is Open On api testing.
     *
     * @return void
     */
    public function test_that_is_open_on_is_working()
    {
        $response = $this->get('/api/is-open-one');
        $response->assertStatus(200);
    }

    /**
     * Nearest Open Date testing.
     *
     * @return void
     */
    public function test_that_nearest_open_date_is_working()
    {
        $response = $this->get('/api/nearest-open-date');
        $this->assertThat(
            $response->getStatusCode(),
            $this->logicalOr(
                $this->equalTo(200),
                $this->equalTo(404)
            )
        );
    }
}
