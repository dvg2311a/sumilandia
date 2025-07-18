<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LessonRequest;
use App\Models\Lesson;
use App\Models\Unit;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Inertia\Inertia;

class LessonController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Lesson::class);
        $user = auth()->user();
        $permissions = [
            'create' => $user->can('create lessons'),
            'view' => $user->can('read lessons'),
            'edit' => $user->can('update lessons'),
            'delete' => $user->can('destroy lessons'),
        ];
        $lessons = Lesson::with('unit')->paginate(10);
        return Inertia::render('Lessons/Index', [
            'lessons' => $lessons,
            'permissions' => $permissions
        ]);
    }

    public function show(Lesson $lesson)
    {
        $this->authorize('view', $lesson);
        $lesson->load('unit');
        return Inertia::render('Lessons/Show', [
            'lesson' => $lesson
        ]);
    }

    public function create()
    {
        $this->authorize('create', Lesson::class);
        $units = Unit::all();
        return Inertia::render('Lessons/Create', [
            'units' => $units
        ]);
    }

    public function store(LessonRequest $request)
    {
        $this->authorize('create', Lesson::class);
        Lesson::create($request->validated());
        return redirect()->route('lessons.index')->with('success', 'Lección creada correctamente');
    }

    public function edit(Lesson $lesson)
    {
        $this->authorize('update', $lesson);
        $units = Unit::all();
        return Inertia::render('Lessons/Edit', [
            'lesson' => $lesson,
            'units' => $units
        ]);
    }

    public function update(LessonRequest $request, Lesson $lesson)
    {
        $this->authorize('update', $lesson);
        $lesson->update($request->validated());
        return redirect()->route('lessons.index')->with('success', 'Lección actualizada correctamente');
    }

    public function destroy(Lesson $lesson)
    {
        $this->authorize('destroy', $lesson);
        $lesson->delete();
        return redirect()->route('lessons.index')->with('success', 'Lección eliminada correctamente');
    }
}
