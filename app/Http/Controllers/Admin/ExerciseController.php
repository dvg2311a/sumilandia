<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExerciseRequest;
use App\Models\Lesson;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use App\Models\Exercise;
use App\Models\ExerciseType;
use App\Classes\ExerciseTypeLogic;

class ExerciseController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Exercise::class);
        $user = auth()->user();
        $permissions = [
            'create' => $user->can('create exercises'),
            'view' => $user->can('read exercises'),
            'edit' => $user->can('update exercises'),
            'delete' => $user->can('destroy exercises'),
        ];
        $exercises = Exercise::with('exerciseType', 'lesson')->paginate(10);
        return Inertia::render('Exercises/Index', [
            'exercises' => $exercises,
            'permissions' => $permissions
        ]);
    }

    public function create()
    {
        $this->authorize('create', Exercise::class);
        $types = ExerciseType::all();
        $lessons = Lesson::all();
        return Inertia::render('Exercises/Create', [
            'types' => $types,
            'lessons' => $lessons
        ]);
    }
    public function store(ExerciseRequest $request): RedirectResponse
    {
        $this->authorize('create', Exercise::class);
        $data = $request->validated();
        $type = ExerciseType::find($data['exercise_type_id']);
        if (!$type) {
            return back()->withErrors(['exercise_type_id' => 'Tipo de ejercicio inválido.']);
        }

        $result = ExerciseTypeLogic::validateAndProcess($type->name, $data);
        if (!empty($result['errors'])) {
            return back()->withErrors($result['errors']);
        }
        Exercise::create($result['data']);
        return redirect()->route('exercises.index')->with('success', 'Ejercicio creado correctamente');
    }

    public function show(Exercise $exercise)
    {
        $this->authorize('view', $exercise);
        $exercise->load('exerciseType', 'lesson');
        return Inertia::render('Exercises/Show', [
            'exercise' => $exercise
        ]);
    }

    public function edit(Exercise $exercise)
    {
        $this->authorize('update', $exercise);
        $types = ExerciseType::all();
        $lessons = Lesson::all();
        return Inertia::render('Exercises/Edit', [
            'exercise' => $exercise,
            'types' => $types,
            'lessons' => $lessons
        ]);
    }

    public function update(ExerciseRequest $request, Exercise $exercise): RedirectResponse
    {
        $this->authorize('update', $exercise);
        $data = $request->validated();
        $type = ExerciseType::find($data['exercise_type_id']);
        if (!$type) {
            return back()->withErrors(['exercise_type_id' => 'Tipo de ejercicio inválido.']);
        }

        $result = ExerciseTypeLogic::validateAndProcess($type->name, $data);
        if (!empty($result['errors'])) {
            return back()->withErrors($result['errors']);
        }
        $exercise->update($result['data']);
        return redirect()->route('exercises.index')->with('success', 'Ejercicio actualizado correctamente');
    }

    public function destroy(Exercise $exercise): RedirectResponse
    {
        $this->authorize('destroy', $exercise);
        $exercise->delete();
        return redirect()->route('exercises.index')->with('success', 'Ejercicio eliminado correctamente');
    }
}
