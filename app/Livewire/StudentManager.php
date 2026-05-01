<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StudentManager extends Component
{
    public $students;
    public $student_id, $name, $email, $password, $date_of_birth, $address;
    public $isOpen = false;

    public function mount()
    {
        $this->loadStudents();
    }

    public function loadStudents()
    {
        $this->students = Student::with('user')->get();
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->student_id = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->date_of_birth = '';
        $this->address = '';
    }

    public function store()
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . ($this->student_id ? Student::find($this->student_id)->user_id : 'NULL'),
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string',
        ];

        if (!$this->student_id) {
            $rules['password'] = 'required|min:6';
        }

        $this->validate($rules);

        if ($this->student_id) {
            $student = Student::find($this->student_id);
            $user = $student->user;
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
            ]);
            if ($this->password) {
                $user->update(['password' => Hash::make($this->password)]);
            }
            $student->update([
                'date_of_birth' => $this->date_of_birth,
                'address' => $this->address,
            ]);
        } else {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);
            $user->assignRole('student');

            Student::create([
                'user_id' => $user->id,
                'date_of_birth' => $this->date_of_birth,
                'address' => $this->address,
            ]);
        }

        session()->flash('message', $this->student_id ? 'Estudiante actualizado.' : 'Estudiante creado.');

        $this->closeModal();
        $this->loadStudents();
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $this->student_id = $id;
        $this->name = $student->user->name;
        $this->email = $student->user->email;
        $this->date_of_birth = $student->date_of_birth ? $student->date_of_birth->format('Y-m-d') : '';
        $this->address = $student->address;
        $this->password = '';
        $this->openModal();
    }

    public function delete($id)
    {
        $student = Student::find($id);
        $student->user->delete(); // This cascades or we can delete user which deletes student
        session()->flash('message', 'Estudiante eliminado.');
        $this->loadStudents();
    }

    public function render()
    {
        return view('livewire.student-manager')->layout('layouts.livewire');
    }
}
