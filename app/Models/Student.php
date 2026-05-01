<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'date_of_birth', 'address'];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'enrollments')
                    ->using(Enrollment::class)
                    ->withPivot('status', 'final_grade', 'enrolled_at')
                    ->withTimestamps();
    }

    public function scopeTopPerformers($query)
    {
        return $query->whereHas('enrollments', function ($q) {
            $q->where('final_grade', '>=', 9.0);
        });
    }

    public function scopeNeedsReinforcement($query)
    {
        return $query->whereHas('enrollments', function ($q) {
            $q->whereNotNull('final_grade')->where('final_grade', '<=', 5.0);
        });
    }
}
