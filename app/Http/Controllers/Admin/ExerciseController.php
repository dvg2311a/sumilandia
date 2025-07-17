<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExerciseRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class ExerciseController extends Controller
{
    public function create()
    {
        return Inertia::render('Exercises/Create');
    }

    public function store(ExerciseRequest $request): RedirectResponse
    {
        return redirect()->route('exercises.index')->with('success', 'Ejercicio creado correctamente');
    }
}
