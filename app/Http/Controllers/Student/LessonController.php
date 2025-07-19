<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LessonController extends Controller
{
    public function index($unitId)
    {
        $unit = Unit::with('lessons')->findOrFail($unitId);
        return Inertia::render('Student/Lessons/Index', [
            'unit' => $unit,
            'lessons' => $unit->lessons
        ]);
    }
}
