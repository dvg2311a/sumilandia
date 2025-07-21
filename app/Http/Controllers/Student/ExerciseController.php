<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\UserExerciseAttempt;
use App\Http\Requests\UserExerciseAttemptRequest;
use Inertia\Inertia;

class ExerciseController extends Controller
{
    public function showSequence($lessonId)
    {
        $lesson = Lesson::with('exercises.exerciseType')->findOrFail($lessonId);

        $exercises = $lesson->exercises->map(function ($exercise) {
            $exerciseArr = $exercise->toArray();
            $exerciseArr['options'] = is_array($exercise->options) ? $exercise->options : json_decode($exercise->options, true);
            return $exerciseArr;
        });
        return Inertia::render('Student/Exercises/Sequence', [
            'lesson' => $lesson,
            'exercises' => $exercises
        ]);
    }
    /**
     * Guarda un intento de ejercicio del estudiante
     */

    public function storeAttemptsBatch(UserExerciseAttemptRequest $request)
    {
        $userId = $request->user()->id;
        $attempts = $request->input('attempts');

        foreach ($attempts as $attempt) {
            UserExerciseAttempt::updateOrCreate(
                [
                    'user_id' => $userId,
                    'exercise_id' => $attempt['exercise_id'],
                    'attempt_number' => $attempt['attempt_number'],
                ],
                [
                    'answer_given' => $attempt['answer_given'],
                    'is_correct' => $attempt['is_correct'],
                    'started_at' => $attempt['started_at'] ?? now(),
                    'answered_at' => now(),
                ]
            );
        }

        $lessonId = $attempts[0]['lesson_id'] ?? null;
        $unitId = $attempts[0]['unit_id'] ?? null;

        if ($unitId) {
            return redirect()->route('student.units.start', $unitId);
        }
        return redirect()->route('student.units.index');
    }
}
