<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpPresence extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'check_in',
        'check_out',
        'late_in',
        'early_out',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($presence) {
            $presence->calculateLateAndEarly($presence->check_in, $presence->check_out);
        });

        static::updating(function ($presence) {
            $presence->calculateLateAndEarly($presence->check_in, $presence->check_out);
        });
    }

    private function calculateLateAndEarly($checkIn, $checkOut)
    {
        $workStart = strtotime('08:00:00');
        $workEnd = strtotime('17:00:00');

        // Hitung keterlambatan
        $checkInTime = strtotime($checkIn);
        if ($checkInTime > $workStart) {
            $this->late_in = ($checkInTime - $workStart) / 60; 
        } else {
            $this->late_in = ($workStart - $checkInTime) / 60; 
        }

        // Hitung pulang cepat
        $checkOutTime = strtotime($checkOut);
        if ($checkOutTime < $workEnd) {
            $this->early_out = ($checkOutTime - $workEnd) / 60; 
        } else {
            $this->early_out = 0; // tidak dihitung jika pulang lebih dari jam kerja
        }
    }

    /**
     * Relasi ke tabel employees.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
