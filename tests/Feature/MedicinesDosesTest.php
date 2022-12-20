<?php

namespace Tests\Feature;

use App\Models\Medicines;
use App\Models\MedicinesDoses;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MedicinesDosesTest extends TestCase
{
    use RefreshDatabase;

    public function test_try_add_new_medicines_dose()
    {
        $texetin = Medicines::prepare('Texetin', 'mg');
        $betocard = Medicines::prepare('Betocard', 'mg');
        $texetinDoseId = MedicinesDoses::tryAddOrUpdate(0, [
            'medicines_id' => $texetin->id,
            'amount' => 30,
            'schedule' => MedicinesDoses::SCHEDULE_EVERYDAY,
            'active' => 'on',
        ]);
        $betocardDoseId = MedicinesDoses::tryAddOrUpdate(0, [
            'medicines_id' => $betocard->id,
            'amount' => 48.75,
            'schedule' => MedicinesDoses::SCHEDULE_EVERYDAY,
        ]);
        $texetinDose = MedicinesDoses::find($texetinDoseId);
        $betocardDose = MedicinesDoses::find($betocardDoseId);

        $this->assertGreaterThan(0, $texetinDoseId);
        $this->assertGreaterThan(0, $betocardDoseId);
        $this->assertDatabaseCount('medicines', 2);
        $this->assertDatabaseCount('medicines_doses', 2);
        $this->assertSame('Texetin', $texetinDose->medicines->name);
        $this->assertSame('Betocard', $betocardDose->medicines->name);
        $this->assertSame(1, $texetinDose->active);
        $this->assertSame(0, $betocardDose->active);
    }

    public function test_try_update_medicines_dose()
    {
        $texetin = Medicines::prepare('Texetin', 'mg');
        $texetinDose = MedicinesDoses::prepare($texetin->id, 20, MedicinesDoses::SCHEDULE_EVERYDAY, false);
        $texetinDoseId = MedicinesDoses::tryAddOrUpdate($texetinDose->id, [
            'medicines_id' => $texetin->id,
            'amount' => 25,
            'schedule' => MedicinesDoses::SCHEDULE_EVERYDAY,
            'active' => 'on',
        ]);
        $texetinDoseUpdated = MedicinesDoses::find($texetinDoseId);

        $this->assertGreaterThan(0, $texetinDoseId);
        $this->assertDatabaseCount('medicines', 1);
        $this->assertDatabaseCount('medicines_doses', 1);
        $this->assertSame(20.0, $texetinDose->amount);
        $this->assertSame(25.0, $texetinDoseUpdated->amount);
        $this->assertSame(0, $texetinDose->active);
        $this->assertSame(1, $texetinDoseUpdated->active);
    }

    public function test_try_delete_medicines_dose()
    {
        $texetin = Medicines::prepare('Texetin', 'mg');
        $texetinDose = MedicinesDoses::prepare($texetin->id, 20, MedicinesDoses::SCHEDULE_EVERYDAY, false);
        $texetinDoseId = MedicinesDoses::tryDelete($texetinDose->id);

        $this->assertGreaterThan(0, $texetinDoseId);
        $this->assertDatabaseCount('medicines', 1);
        $this->assertDatabaseCount('medicines_doses', 0);
    }
}
