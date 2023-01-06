<?php

namespace App\Models;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessTime extends Model
{
    use HasFactory;
protected $fillable = [
   'expert_id',
    'days',];
    protected $casts = [
    'mon_s' => 'date:hh:mm',
    'mon_e' => 'date:hh:mm',
    'tue_s' => 'date:hh:mm',
    'tue_e' => 'date:hh:mm',
    'wed_s' => 'date:hh:mm',
    'wed_e' => 'date:hh:mm',
    'thu_s' => 'date:hh:mm',
    'thu_e' => 'date:hh:mm',
    'fri_s' => 'date:hh:mm',
    'fri_e' => 'date:hh:mm',
    'sat_s' => 'date:hh:mm',
    'sat_e' => 'date:hh:mm',
    'sun_s' => 'date:hh:mm',
    'sun_e' => 'date:hh:mm'
    

];
    

public function getTimesPeriodAttribute()
    {
        $times = CarbonInterval::minutes($this->step)->toPeriod($this->from, $this->to)->toArray();

        return array_map(fn($time)=> $time->format('H:i'),$times);
}
}