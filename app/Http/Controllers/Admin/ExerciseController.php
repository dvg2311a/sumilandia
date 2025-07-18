<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExerciseRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use App\Models\Exercise;
use App\Models\ExerciseType;
use App\Classes\ExerciseTypeLogic;

class ExerciseController extends Controller
{
    public function index()
    {
        $exercises = Exercise::with('exerciseType', 'lesson')->paginate(10);
        return Inertia::render('Exercises/Index', [
            'exercises' => $exercises
        ]);
    }

    public function create()
    {
        $types = ExerciseType::all();
        return Inertia::render('Exercises/Create', [
            'types' => $types
        ]);
    }
    public function store(ExerciseRequest $request): RedirectResponse
    {
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
        $exercise->load('exerciseType', 'lesson');
        return Inertia::render('Exercises/Show', [
            'exercise' => $exercise
        ]);
    }

    public function edit(Exercise $exercise)
    {
        $types = ExerciseType::all();
        return Inertia::render('Exercises/Edit', [
            'exercise' => $exercise,
            'types' => $types
        ]);
    }

    public function update(ExerciseRequest $request, Exercise $exercise): RedirectResponse
    {
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
        $exercise->delete();
        return redirect()->route('exercises.index')->with('success', 'Ejercicio eliminado correctamente');
    }
}
