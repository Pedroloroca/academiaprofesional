<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;

class PublicCatalog extends Component
{
    public $scope;

    public function mount($scope = null)
    {
        if ($scope === 'professional') {
            $scope = 'profesional';
        }
        if ($scope === 'school') {
            $scope = 'escolar';
        }
        $this->scope = $scope;
    }

    public function render()
    {
        // Using the scopePublished we created earlier
        $query = Course::published()->with('teacher.user');

        if ($this->scope) {
            $query->where('scope', $this->scope);
        }

        $courses = $query->get();
        return view('livewire.public-catalog', compact('courses'))->layout('layouts.livewire');
    }
}
