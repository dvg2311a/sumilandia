<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Models\Lesson;
use App\Models\User;
use App\Models\UnitUserProgress;
use App\Models\LessonUserProgress;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProgressController extends Controller
{
    public function index(Request $request)
    {
        // Filtros opcionales
        $unitId = $request->input('unit_id');
        $userId = $request->input('user_id');
        $lessonId = $request->input('lesson_id');
        $status = $request->input('status');

        $units = Unit::all();
        $users = User::all();
        $lessons = Lesson::all();

        // Filtrar por unidad, usuario, lección y estado en LessonUserProgress
        $query = LessonUserProgress::with(['user', 'lesson.unit']);
        if ($unitId) {
            $lessonIds = Lesson::where('unit_id', $unitId)->pluck('id');
            $query->whereIn('lesson_id', $lessonIds);
        }
        if ($userId) {
            $query->where('user_id', $userId);
        }
        if ($lessonId) {
            $query->where('lesson_id', $lessonId);
        }
        if ($status) {
            $query->where('status', $status);
        }
        $progress = $query->get();

        return Inertia::render('Admin/Progress/Index', [
            'units' => $units,
            'users' => $users,
            'lessons' => $lessons,
            'progress' => $progress,
            'selectedUnit' => $unitId,
            'selectedUser' => $userId,
            'selectedLesson' => $lessonId,
            'selectedStatus' => $status
        ]);
    }
}
