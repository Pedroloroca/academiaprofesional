<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;

class PublicCatalog extends Component
{
    public function render()
    {
        // Using the scopePublished we created earlier
        $courses = Course::published()->with('teacher.user')->get();
        return view('livewire.public-catalog', compact('courses'))->layout('layouts.livewire');
    }
}
