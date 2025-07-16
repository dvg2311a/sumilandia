<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Unit;
use App\Models\Level;
use App\Http\Requests\UnitRequest;
use Inertia\Inertia;

class UnitController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $this->authorize('viewAny', Unit::class);
        $units = Unit::with('level')->get();
        return Inertia::render('Units/Index', [
            'units' => $units
        ]);
    }

    public function create()
    {
        $this->authorize('create', Unit::class);
        $levels = Level::all();
        return Inertia::render('Units/Create', [
            'levels' => $levels
        ]);
    }

    public function store(UnitRequest $request)
    {
        Unit::create($request->validated());
        return redirect()->route('units.index')->with('success', 'Unidad creada correctamente');
    }

    public function edit(Unit $unit)
    {
        $this->authorize('update', $unit);
        $levels = Level::all();
        return Inertia::render('Units/Edit', [
            'unit' => $unit,
            'levels' => $levels
        ]);
    }

    public function update(UnitRequest $request, Unit $unit)
    {
        $unit->update($request->validated());
        return redirect()->route('units.index')->with('success', 'Unidad actualizada correctamente');
    }

    public function destroy(Unit $unit)
    {
        $this->authorize('destroy', $unit);
        $unit->delete();
        return redirect()->route('units.index')->with('success', 'Unidad eliminada correctamente');
    }
}
