<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Student;
use App\Models\Enrollment;

class DashboardStats extends Component
{
    public function render()
    {
        $stats = [
            'total_courses' => Course::count(),
            'published_courses' => Course::published()->count(),
            'total_students' => Student::count(),
            'active_enrollments' => Enrollment::where('status', 'active')->count(),
        ];

        return view('livewire.dashboard-stats', compact('stats'));
    }
}
