<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthReport extends Model
{
    protected $fillable = [
    'worker_name',
    'patient_count',
    'disease_reported',
    'location',
    'severity',
     'report_date',
     'user_id'
];

public function user(){
    return $this->belongsTo(User::class);
}
}


