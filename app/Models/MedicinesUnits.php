<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicinesUnits extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function medicines()
    {
        return $this->belongsTo(Medicines::class);
    }
}
