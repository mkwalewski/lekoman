<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicines extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function units()
    {
        return $this->hasMany(MedicinesUnits::class);
    }

    public function histories()
    {
        return $this->hasMany(MedicinesHistory::class);
    }

    public static function prepare(string $name, string $unit): Medicines
    {
        $medicine = new Medicines();
        $medicine->name = $name;
        $medicine->unit = $unit;
        $medicine->save();

        return $medicine;
    }
}
