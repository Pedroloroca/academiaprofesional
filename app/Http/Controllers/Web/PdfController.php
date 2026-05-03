<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\Enrollment;
use App\Models\Course;
use App\Models\Teacher;

class PdfController extends Controller
{
    public function welcome(User $user)
    {
        $pdf = Pdf::loadView('pdfs.welcome', compact('user'));
        return $pdf->stream("welcome-{$user->id}.pdf");
    }

    public function invoice(Enrollment $enrollment)
    {
        $enrollment->load('student.user', 'course');
        $pdf = Pdf::loadView('pdfs.invoice', compact('enrollment'));
        return $pdf->stream("invoice-{$enrollment->id}.pdf");
    }

    public function certificate(Enrollment $enrollment)
    {
        $enrollment->load('student.user', 'course');
        $pdf = Pdf::loadView('pdfs.certificate', compact('enrollment'));
        return $pdf->stream("certificate-{$enrollment->id}.pdf");
    }

    public function courseCatalog()
    {
        $courses = Course::with('teacher.user')->get();
        $pdf = Pdf::loadView('pdfs.course-catalog', compact('courses'));
        return $pdf->stream("course-catalog.pdf");
    }

    public function teacherReport(Teacher $teacher)
    {
        $teacher->load('user', 'courses.enrollments');
        $pdf = Pdf::loadView('pdfs.teacher-report', compact('teacher'));
        return $pdf->stream("teacher-report-{$teacher->id}.pdf");
    }
}
