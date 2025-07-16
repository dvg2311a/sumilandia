<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Lesson;
use App\Http\Requests\LessonRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LessonController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Lesson::class);
        $lessons = Lesson::with('unit')->paginate(10);
        return Inertia::render('Lessons/Index', [
            'lessons' => $lessons
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
        return Inertia::render('Lessons/Create');
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
        return Inertia::render('Lessons/Edit', [
            'lesson' => $lesson
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
