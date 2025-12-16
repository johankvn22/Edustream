<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\StudentProgress;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Display lesson player (video/pdf/quiz)
     */
    public function show($courseId, $lessonId)
    {
        $course = Course::with('lessons')->findOrFail($courseId);
        $lesson = Lesson::with('questions.options')->findOrFail($lessonId);
        
        // Verify lesson belongs to course
        if ($lesson->course_id != $courseId) {
            abort(404);
        }

        return view('student.lesson.show', compact('course', 'lesson'));
    }

    /**
     * Submit quiz answers and calculate score
     */
    public function submitQuiz(Request $request, $lessonId)
    {
        $lesson = Lesson::with('questions.options')->findOrFail($lessonId);
        
        if ($lesson->type !== 'quiz') {
            return back()->withErrors(['error' => 'Lesson bukan kuis']);
        }

        $answers = $request->input('answers', []);
        $totalQuestions = $lesson->questions->count();
        $correctAnswers = 0;

        foreach ($lesson->questions as $question) {
            $userAnswer = $answers[$question->id] ?? null;
            $correctOption = $question->options->where('is_correct', true)->first();
            
            if ($userAnswer !== null && $correctOption && $userAnswer == $correctOption->id) {
                $correctAnswers++;
            }
        }

        $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0;

        // Save progress
        StudentProgress::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'lesson_id' => $lessonId,
            ],
            [
                'is_completed' => true,
                'quiz_score' => $score,
                'completed_at' => now(),
            ]
        );

        return response()->json([
            'score' => $score,
            'correct' => $correctAnswers,
            'total' => $totalQuestions
        ]);
    }
}
