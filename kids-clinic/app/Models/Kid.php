<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kid extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function getAgeAttribute()
    {
        if (!$this->date_of_birth) return '-';
        
        $dob = \Carbon\Carbon::parse($this->date_of_birth);
        $diff = $dob->diff(\Carbon\Carbon::now());
        
        if ($diff->y < 1) {
            return "{$diff->m} شهر و {$diff->d} يوم";
        }
        
        return "{$diff->y} سنة و {$diff->m} شهر";
    }
}
