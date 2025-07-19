<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\Unit;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        $levelId = $request->input('level_id');
        $levels = Level::all();
        $unitsQuery = Unit::query();
        if ($levelId) {
            $unitsQuery->where('level_id', $levelId);
        }
        $units = $unitsQuery->with('level')->get();
        return Inertia::render('Student/Units/Index', [
            'levels' => $levels,
            'units' => $units,
            'selectedLevel' => $levelId
        ]);
    }
}
