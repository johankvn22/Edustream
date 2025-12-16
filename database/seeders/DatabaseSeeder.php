<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SchoolClass;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\Option;
use App\Models\StudentProgress;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed demo users (teacher, student, admin)
        $this->call(UserSeeder::class);

        // ========== CLASSES ==========
        $class10Rpl1 = SchoolClass::create(['name' => '10 RPL 1', 'grade_level' => 10]);
        $class10Rpl2 = SchoolClass::create(['name' => '10 RPL 2', 'grade_level' => 10]);
        $class11Rpl1 = SchoolClass::create(['name' => '11 RPL 1', 'grade_level' => 11]);
        $class11Rpl2 = SchoolClass::create(['name' => '11 RPL 2', 'grade_level' => 11]);
        $class12Rpl1 = SchoolClass::create(['name' => '12 RPL 1', 'grade_level' => 12]);

        // ========== TEACHERS ==========
        $teacher1 = User::create([
            'name' => 'Pak Budi Santoso',
            'email' => 'guru@sekolah.id',
            'password' => Hash::make('guru'),
            'role' => 'teacher',
            'class_id' => null,
        ]);

        $teacher2 = User::create([
            'name' => 'Ibu Siti Nurhaliza',
            'email' => 'siti@sekolah.id',
            'password' => Hash::make('guru'),
            'role' => 'teacher',
            'class_id' => null,
        ]);

        // ========== STUDENTS - Class 10 RPL 1 ==========
        $students = [];
        
        $students[] = User::create([
            'name' => 'Andi Saputra',
            'email' => 'andi@sekolah.id',
            'password' => Hash::make('siswa'),
            'role' => 'student',
            'class_id' => $class10Rpl1->id,
        ]);

        $students[] = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@sekolah.id',
            'password' => Hash::make('siswa'),
            'role' => 'student',
            'class_id' => $class10Rpl1->id,
        ]);

        User::create([
            'name' => 'Deni Pratama',
            'email' => 'deni@sekolah.id',
            'password' => Hash::make('siswa'),
            'role' => 'student',
            'class_id' => $class10Rpl1->id,
        ]);

        User::create([
            'name' => 'Fitri Handayani',
            'email' => 'fitri@sekolah.id',
            'password' => Hash::make('siswa'),
            'role' => 'student',
            'class_id' => $class10Rpl1->id,
        ]);

        User::create([
            'name' => 'Galih Pratama',
            'email' => 'galih@sekolah.id',
            'password' => Hash::make('siswa'),
            'role' => 'student',
            'class_id' => $class10Rpl1->id,
        ]);

        // ========== STUDENTS - Class 10 RPL 2 ==========
        User::create([
            'name' => 'Eka Putri',
            'email' => 'eka@sekolah.id',
            'password' => Hash::make('siswa'),
            'role' => 'student',
            'class_id' => $class10Rpl2->id,
        ]);

        User::create([
            'name' => 'Hadi Wijaya',
            'email' => 'hadi@sekolah.id',
            'password' => Hash::make('siswa'),
            'role' => 'student',
            'class_id' => $class10Rpl2->id,
        ]);

        User::create([
            'name' => 'Intan Permata',
            'email' => 'intan@sekolah.id',
            'password' => Hash::make('siswa'),
            'role' => 'student',
            'class_id' => $class10Rpl2->id,
        ]);

        // ========== STUDENTS - Class 11 RPL 1 ==========
        $students[] = User::create([
            'name' => 'Citra Lestari',
            'email' => 'citra@sekolah.id',
            'password' => Hash::make('siswa'),
            'role' => 'student',
            'class_id' => $class11Rpl1->id,
        ]);

        User::create([
            'name' => 'Joko Susilo',
            'email' => 'joko@sekolah.id',
            'password' => Hash::make('siswa'),
            'role' => 'student',
            'class_id' => $class11Rpl1->id,
        ]);

        User::create([
            'name' => 'Kartika Sari',
            'email' => 'kartika@sekolah.id',
            'password' => Hash::make('siswa'),
            'role' => 'student',
            'class_id' => $class11Rpl1->id,
        ]);

        // ========== STUDENTS - Class 11 RPL 2 ==========
        User::create([
            'name' => 'Lina Marlina',
            'email' => 'lina@sekolah.id',
            'password' => Hash::make('siswa'),
            'role' => 'student',
            'class_id' => $class11Rpl2->id,
        ]);

        User::create([
            'name' => 'Made Yasa',
            'email' => 'made@sekolah.id',
            'password' => Hash::make('siswa'),
            'role' => 'student',
            'class_id' => $class11Rpl2->id,
        ]);

        // ========== STUDENTS - Class 12 RPL 1 ==========
        User::create([
            'name' => 'Nina Safitri',
            'email' => 'nina@sekolah.id',
            'password' => Hash::make('siswa'),
            'role' => 'student',
            'class_id' => $class12Rpl1->id,
        ]);

        User::create([
            'name' => 'Oki Setiawan',
            'email' => 'oki@sekolah.id',
            'password' => Hash::make('siswa'),
            'role' => 'student',
            'class_id' => $class12Rpl1->id,
        ]);

        // ========== COURSES ==========
        $course1 = Course::create([
            'title' => 'Dasar Pemrograman Web',
            'slug' => 'dasar-pemrograman-web',
            'category' => 'Kelas 10 RPL',
            'thumbnail' => '💻',
            'color_theme' => 'bg-blue-600',
            'teacher_id' => $teacher1->id,
        ]);

        $course2 = Course::create([
            'title' => 'Laravel Framework 10',
            'slug' => 'laravel-framework-10',
            'category' => 'Kelas 11 RPL',
            'thumbnail' => '🔥',
            'color_theme' => 'bg-red-600',
            'teacher_id' => $teacher1->id,
        ]);

        $course3 = Course::create([
            'title' => 'UI/UX Design',
            'slug' => 'ui-ux-design',
            'category' => 'Kelas 12 RPL',
            'thumbnail' => '🎨',
            'color_theme' => 'bg-purple-600',
            'teacher_id' => $teacher2->id,
        ]);

        $course4 = Course::create([
            'title' => 'Database MySQL',
            'slug' => 'database-mysql',
            'category' => 'Kelas 11 RPL',
            'thumbnail' => '🗄️',
            'color_theme' => 'bg-green-600',
            'teacher_id' => $teacher1->id,
        ]);

        $course5 = Course::create([
            'title' => 'JavaScript Modern',
            'slug' => 'javascript-modern',
            'category' => 'Kelas 10 RPL',
            'thumbnail' => '⚡',
            'color_theme' => 'bg-yellow-600',
            'teacher_id' => $teacher2->id,
        ]);

        // ========== ASSIGN COURSES TO CLASSES ==========
        $course1->classes()->attach([$class10Rpl1->id, $class10Rpl2->id]);
        $course2->classes()->attach([$class11Rpl1->id, $class11Rpl2->id]);
        $course3->classes()->attach([$class12Rpl1->id]);
        $course4->classes()->attach([$class11Rpl1->id]);
        $course5->classes()->attach([$class10Rpl1->id]);

        // ========== LESSONS FOR COURSE 1 (Dasar Pemrograman Web) ==========
        $lesson1_1 = Lesson::create([
            'course_id' => $course1->id,
            'title' => 'Pengenalan HTML',
            'type' => 'video',
            'content_url' => 'https://www.youtube.com/watch?v=example1',
            'duration_seconds' => 600,
            'order_sequence' => 1,
        ]);

        $lesson1_2 = Lesson::create([
            'course_id' => $course1->id,
            'title' => 'Modul HTML PDF',
            'type' => 'pdf',
            'content_url' => '/storage/pdfs/html-module.pdf',
            'duration_seconds' => 300,
            'order_sequence' => 2,
        ]);

        $lesson1_3 = Lesson::create([
            'course_id' => $course1->id,
            'title' => 'Kuis Dasar HTML',
            'type' => 'quiz',
            'content_url' => null,
            'duration_seconds' => 120,
            'order_sequence' => 3,
        ]);

        $lesson1_4 = Lesson::create([
            'course_id' => $course1->id,
            'title' => 'CSS Styling',
            'type' => 'video',
            'content_url' => 'https://www.youtube.com/watch?v=example2',
            'duration_seconds' => 720,
            'order_sequence' => 4,
        ]);

        $lesson1_5 = Lesson::create([
            'course_id' => $course1->id,
            'title' => 'Kuis CSS',
            'type' => 'quiz',
            'content_url' => null,
            'duration_seconds' => 180,
            'order_sequence' => 5,
        ]);

        // ========== QUESTIONS FOR QUIZ 1 (Kuis Dasar HTML) ==========
        $q1_1 = Question::create([
            'lesson_id' => $lesson1_3->id,
            'question_text' => 'Tag HTML untuk membuat link adalah?',
        ]);
        Option::create(['question_id' => $q1_1->id, 'option_text' => '<a>', 'is_correct' => true]);
        Option::create(['question_id' => $q1_1->id, 'option_text' => '<img>', 'is_correct' => false]);
        Option::create(['question_id' => $q1_1->id, 'option_text' => '<p>', 'is_correct' => false]);
        Option::create(['question_id' => $q1_1->id, 'option_text' => '<div>', 'is_correct' => false]);

        $q1_2 = Question::create([
            'lesson_id' => $lesson1_3->id,
            'question_text' => 'Kepanjangan HTML?',
        ]);
        Option::create(['question_id' => $q1_2->id, 'option_text' => 'High Text', 'is_correct' => false]);
        Option::create(['question_id' => $q1_2->id, 'option_text' => 'Hyper Text Markup Language', 'is_correct' => true]);
        Option::create(['question_id' => $q1_2->id, 'option_text' => 'Hyper Tool', 'is_correct' => false]);
        Option::create(['question_id' => $q1_2->id, 'option_text' => 'Home Tool', 'is_correct' => false]);

        $q1_3 = Question::create([
            'lesson_id' => $lesson1_3->id,
            'question_text' => 'Tag untuk membuat heading terbesar adalah?',
        ]);
        Option::create(['question_id' => $q1_3->id, 'option_text' => '<h1>', 'is_correct' => true]);
        Option::create(['question_id' => $q1_3->id, 'option_text' => '<h6>', 'is_correct' => false]);
        Option::create(['question_id' => $q1_3->id, 'option_text' => '<header>', 'is_correct' => false]);
        Option::create(['question_id' => $q1_3->id, 'option_text' => '<head>', 'is_correct' => false]);

        // ========== QUESTIONS FOR QUIZ 2 (Kuis CSS) ==========
        $q2_1 = Question::create([
            'lesson_id' => $lesson1_5->id,
            'question_text' => 'Properti CSS untuk mengubah warna teks adalah?',
        ]);
        Option::create(['question_id' => $q2_1->id, 'option_text' => 'color', 'is_correct' => true]);
        Option::create(['question_id' => $q2_1->id, 'option_text' => 'text-color', 'is_correct' => false]);
        Option::create(['question_id' => $q2_1->id, 'option_text' => 'font-color', 'is_correct' => false]);
        Option::create(['question_id' => $q2_1->id, 'option_text' => 'background-color', 'is_correct' => false]);

        $q2_2 = Question::create([
            'lesson_id' => $lesson1_5->id,
            'question_text' => 'Selector untuk memilih element dengan id "header" adalah?',
        ]);
        Option::create(['question_id' => $q2_2->id, 'option_text' => '.header', 'is_correct' => false]);
        Option::create(['question_id' => $q2_2->id, 'option_text' => '#header', 'is_correct' => true]);
        Option::create(['question_id' => $q2_2->id, 'option_text' => 'header', 'is_correct' => false]);
        Option::create(['question_id' => $q2_2->id, 'option_text' => '*header', 'is_correct' => false]);

        // ========== LESSONS FOR COURSE 2 (Laravel Framework) ==========
        $lesson2_1 = Lesson::create([
            'course_id' => $course2->id,
            'title' => 'Konsep MVC',
            'type' => 'video',
            'content_url' => 'https://www.youtube.com/watch?v=mvc',
            'duration_seconds' => 900,
            'order_sequence' => 1,
        ]);

        $lesson2_2 = Lesson::create([
            'course_id' => $course2->id,
            'title' => 'Routing di Laravel',
            'type' => 'video',
            'content_url' => 'https://www.youtube.com/watch?v=routing',
            'duration_seconds' => 720,
            'order_sequence' => 2,
        ]);

        $lesson2_3 = Lesson::create([
            'course_id' => $course2->id,
            'title' => 'Kuis Laravel Basics',
            'type' => 'quiz',
            'content_url' => null,
            'duration_seconds' => 240,
            'order_sequence' => 3,
        ]);

        // ========== QUESTIONS FOR QUIZ 3 (Kuis Laravel) ==========
        $q3_1 = Question::create([
            'lesson_id' => $lesson2_3->id,
            'question_text' => 'M dalam MVC adalah singkatan dari?',
        ]);
        Option::create(['question_id' => $q3_1->id, 'option_text' => 'Model', 'is_correct' => true]);
        Option::create(['question_id' => $q3_1->id, 'option_text' => 'Module', 'is_correct' => false]);
        Option::create(['question_id' => $q3_1->id, 'option_text' => 'Method', 'is_correct' => false]);
        Option::create(['question_id' => $q3_1->id, 'option_text' => 'Main', 'is_correct' => false]);

        // ========== LESSONS FOR COURSE 3 (UI/UX Design) ==========
        Lesson::create([
            'course_id' => $course3->id,
            'title' => 'Prinsip Desain',
            'type' => 'video',
            'content_url' => 'https://www.youtube.com/watch?v=design',
            'duration_seconds' => 1200,
            'order_sequence' => 1,
        ]);

        Lesson::create([
            'course_id' => $course3->id,
            'title' => 'Figma Basics',
            'type' => 'video',
            'content_url' => 'https://www.youtube.com/watch?v=figma',
            'duration_seconds' => 1500,
            'order_sequence' => 2,
        ]);

        // ========== LESSONS FOR COURSE 4 (Database MySQL) ==========
        Lesson::create([
            'course_id' => $course4->id,
            'title' => 'Pengenalan Database',
            'type' => 'video',
            'content_url' => 'https://www.youtube.com/watch?v=db',
            'duration_seconds' => 800,
            'order_sequence' => 1,
        ]);

        // ========== LESSONS FOR COURSE 5 (JavaScript Modern) ==========
        Lesson::create([
            'course_id' => $course5->id,
            'title' => 'ES6 Features',
            'type' => 'video',
            'content_url' => 'https://www.youtube.com/watch?v=es6',
            'duration_seconds' => 1000,
            'order_sequence' => 1,
        ]);

        // ========== STUDENT PROGRESS ==========
        // Andi's progress (partially completed Course 1)
        StudentProgress::create([
            'user_id' => $students[0]->id,
            'lesson_id' => $lesson1_1->id,
            'is_completed' => true,
            'quiz_score' => null,
            'completed_at' => now()->subDays(3),
        ]);

        StudentProgress::create([
            'user_id' => $students[0]->id,
            'lesson_id' => $lesson1_2->id,
            'is_completed' => true,
            'quiz_score' => null,
            'completed_at' => now()->subDays(2),
        ]);

        // Budi's progress (completed Course 1)
        StudentProgress::create([
            'user_id' => $students[1]->id,
            'lesson_id' => $lesson1_1->id,
            'is_completed' => true,
            'quiz_score' => null,
            'completed_at' => now()->subDays(5),
        ]);

        StudentProgress::create([
            'user_id' => $students[1]->id,
            'lesson_id' => $lesson1_2->id,
            'is_completed' => true,
            'quiz_score' => null,
            'completed_at' => now()->subDays(4),
        ]);

        StudentProgress::create([
            'user_id' => $students[1]->id,
            'lesson_id' => $lesson1_3->id,
            'is_completed' => true,
            'quiz_score' => 100,
            'completed_at' => now()->subDays(3),
        ]);

        StudentProgress::create([
            'user_id' => $students[1]->id,
            'lesson_id' => $lesson1_4->id,
            'is_completed' => true,
            'quiz_score' => null,
            'completed_at' => now()->subDays(2),
        ]);

        StudentProgress::create([
            'user_id' => $students[1]->id,
            'lesson_id' => $lesson1_5->id,
            'is_completed' => true,
            'quiz_score' => 75,
            'completed_at' => now()->subDays(1),
        ]);

        // Citra's progress (Course 2)
        StudentProgress::create([
            'user_id' => $students[2]->id,
            'lesson_id' => $lesson2_1->id,
            'is_completed' => true,
            'quiz_score' => null,
            'completed_at' => now()->subDays(1),
        ]);
    }
}
