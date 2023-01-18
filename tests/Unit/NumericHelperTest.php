<?php

namespace Tests\Unit;

use App\Helpers\NumericHelper;
use PHPUnit\Framework\TestCase;

class NumericHelperTest extends TestCase
{
    public function test_calc_percentage_is_valid()
    {
        $percentage1 = NumericHelper::calcPercentage(0, 100);
        $percentage2 = NumericHelper::calcPercentage(25, 100);
        $percentage3 = NumericHelper::calcPercentage(50, 100);
        $percentage4 = NumericHelper::calcPercentage(75, 100);
        $percentage5 = NumericHelper::calcPercentage(100, 100);

        $this->assertSame(0, $percentage1);
        $this->assertSame(25, $percentage2);
        $this->assertSame(50, $percentage3);
        $this->assertSame(75, $percentage4);
        $this->assertSame(100, $percentage5);
    }
}
