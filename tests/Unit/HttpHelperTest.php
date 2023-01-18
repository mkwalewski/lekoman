<?php

namespace Tests\Unit;

use App\Helpers\HttpHelper;
use App\Models\MedicinesDoses;
use PHPUnit\Framework\TestCase;

class HttpHelperTest extends TestCase
{
    public function test_class_for_percentage_is_valid()
    {
        $class1 = HttpHelper::getClassForPercentage(MedicinesDoses::SCHEDULE_EVERYDAY,75);
        $class2 = HttpHelper::getClassForPercentage(MedicinesDoses::SCHEDULE_EVERYDAY,50);
        $class3 = HttpHelper::getClassForPercentage(MedicinesDoses::SCHEDULE_EVERYDAY,25);
        $class4 = HttpHelper::getClassForPercentage(MedicinesDoses::SCHEDULE_EVERYDAY,0);
        $class5 = HttpHelper::getClassForPercentage(MedicinesDoses::SCHEDULE_OCCASIONALLY,75);
        $class6 = HttpHelper::getClassForPercentage(MedicinesDoses::SCHEDULE_OCCASIONALLY,50);
        $class7 = HttpHelper::getClassForPercentage(MedicinesDoses::SCHEDULE_OCCASIONALLY,25);
        $class8 = HttpHelper::getClassForPercentage(MedicinesDoses::SCHEDULE_OCCASIONALLY,0);

        $this->assertSame('danger', $class1);
        $this->assertSame('warning', $class2);
        $this->assertSame('success', $class3);
        $this->assertSame('primary', $class4);
        $this->assertSame('secondary', $class5);
        $this->assertSame('secondary', $class6);
        $this->assertSame('secondary', $class7);
        $this->assertSame('secondary', $class8);
    }
}
