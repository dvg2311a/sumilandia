<?php

namespace App\Http\Controllers;

use App\Http\Requests\LevelRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Level;
use Inertia\Inertia;

class LevelController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Level::class);
        return Inertia::render('Levels/Index', [
            'levels' => Level::all()
        ]);
    }

    public function create()
    {
        $this->authorize('create', Level::class);
        return Inertia::render('Levels/Create');
    }

    public function store(LevelRequest $request)
    {
        Level::create($request->validated());
        return redirect()->route('levels.index')->with('success', 'Nivel creado correctamente');
    }

    public function edit(Level $level)
    {
        $this->authorize('update', $level);
        return Inertia::render('Levels/Edit', [
            'level' => $level
        ]);
    }

    public function update(LevelRequest $request, Level $level)
    {
        $level->update($request->validated());
        return redirect()->route('levels.index')->with('success', 'Nivel actualizado correctamente');
    }

    public function destroy(Level $level)
    {
        $this->authorize('destroy', $level);
        $level->delete();
        return redirect()->route('levels.index')->with('success', 'Nivel eliminado correctamente');
    }
}
