<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Store a new lesson
     */
    public function store(Request $request, $courseId)
    {
        $course = Course::findOrFail($courseId);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:video,pdf,quiz',
            'content_url' => 'nullable|string',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240', // 10MB max
            'duration_seconds' => 'nullable|integer',
        ]);

        // Handle PDF upload
        $contentUrl = $validated['content_url'] ?? null;
        if ($request->hasFile('pdf_file')) {
            $file = $request->file('pdf_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Store in public/storage/pdfs
            $destinationPath = public_path('storage/pdfs');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $file->move($destinationPath, $filename);
            $contentUrl = 'public/storage/pdfs/' . $filename;
        }

        // Convert YouTube URL to embed format
        if ($validated['type'] === 'video' && $contentUrl) {
            $contentUrl = $this->convertToYouTubeEmbed($contentUrl);
        }

        // Get the next order sequence
        $maxOrder = $course->lessons()->max('order_sequence') ?? 0;

        $lesson = $course->lessons()->create([
            'title' => $validated['title'],
            'type' => $validated['type'],
            'content_url' => $contentUrl,
            'duration_seconds' => $validated['duration_seconds'] ?? 0,
            'order_sequence' => $maxOrder + 1,
        ]);

        return back()->with('success', "Materi {$validated['type']} berhasil ditambahkan!");
    }

    /**
     * Remove a lesson
     */
    public function destroy($id)
    {
        $lesson = Lesson::findOrFail($id);
        
        // Delete PDF file if exists
        if ($lesson->type === 'pdf' && $lesson->content_url) {
            $filePath = public_path($lesson->content_url);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        
        $lesson->delete();

        return back()->with('success', 'Materi dihapus.');
    }

    /**
     * Convert YouTube URL to embed format
     */
    private function convertToYouTubeEmbed($url)
    {
        // Handle various YouTube URL formats
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $match)) {
            return 'https://www.youtube.com/embed/' . $match[1];
        }
        
        return $url;
    }
}
