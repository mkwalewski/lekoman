<?php

namespace Tests\Feature;

use App\Helpers\DateHelper;
use Carbon\Carbon;
use Mockery\MockInterface;
use Tests\TestCase;

class DateHelperTest extends TestCase
{
    public function test_should_return_valid_year_with_mock()
    {
        $this->mock(DateHelper::class, function (MockInterface $mock) {
            $mock->shouldReceive('getCurrentYear')->andReturn(1987)->once();
        });
        $year = app(DateHelper::class)->getCurrentYear();

        $this->assertSame(1987, $year);
    }

    public function test_should_return_valid_year_with_travel()
    {
        $magicDate = new Carbon('25-04-1987');
        $this->travelTo($magicDate);
        $year = DateHelper::getCurrentYear();

        $this->assertSame(1987, $year);
    }
}
