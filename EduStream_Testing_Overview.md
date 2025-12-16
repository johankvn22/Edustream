# EduStream Testing Overview

Dokumen ini berisi overview lengkap tentang apa saja yang bisa di-test dalam aplikasi EduStream berdasarkan struktur project yang ada.

## 📊 Ringkasan Project

**EduStream** adalah aplikasi Learning Management System (LMS) dengan 2 role utama:

-   **Teacher** - Membuat course, lesson, manage students, promotion
-   **Student** - Mengakses course, belajar lesson, mengerjakan quiz

## 🎯 Kategori Testing

### 1. Authentication & Authorization Tests

### 2. Controller Tests (Feature Tests)

### 3. Model Tests (Unit Tests)

### 4. Middleware Tests

### 5. Route Tests

### 6. Database Tests

### 7. Integration Tests

---

## 1. Authentication & Authorization Tests

### 📁 File: `tests/Feature/AuthControllerTest.php`

**Method yang Ditest:**

-   `showLanding()` - Halaman landing
-   `showLogin()` - Form login
-   `login()` - Proses login
-   `logout()` - Proses logout
-   `redirectBasedOnRole()` - Role-based redirect

**Test Cases (17-18 tests):**

#### A. Landing Page

-   ✅ Guest dapat akses landing page
-   ✅ Teacher yang sudah login di-redirect ke dashboard teacher
-   ✅ Student yang sudah login di-redirect ke dashboard student

#### B. Login Form

-   ✅ Guest dapat akses halaman login
-   ✅ User yang sudah login di-redirect ke dashboard sesuai role

#### C. Login Process

-   ✅ Login berhasil dengan credentials valid
-   ✅ Teacher redirect ke teacher dashboard
-   ✅ Student redirect ke student dashboard
-   ✅ Login gagal dengan email salah
-   ✅ Login gagal dengan password salah
-   ✅ Validasi email required
-   ✅ Validasi password required
-   ✅ Validasi format email
-   ✅ Session regenerated setelah login

#### D. Logout

-   ✅ User dapat logout
-   ✅ Session di-invalidate setelah logout
-   ✅ Redirect ke landing setelah logout

#### E. Role-Based Access

-   ✅ User dengan role invalid mendapat error

**Priority:** ⭐⭐⭐⭐⭐ (CRITICAL)

---

## 2. Teacher Controller Tests

### 📁 File: `tests/Feature/Teacher/DashboardControllerTest.php`

**Method yang Ditest:**

-   `index()` - Menampilkan dashboard teacher

**Test Cases (3-4 tests):**

-   ✅ Teacher dapat akses dashboard
-   ✅ Dashboard menampilkan data yang benar (courses count, students count, dll)
-   ✅ Student tidak bisa akses teacher dashboard
-   ✅ Guest di-redirect ke login

**Priority:** ⭐⭐⭐⭐

---

### 📁 File: `tests/Feature/Teacher/CourseControllerTest.php`

**Method yang Ditest:**

-   `index()` - List semua courses
-   `create()` - Form create course
-   `store()` - Simpan course baru
-   `show()` - Detail course
-   `edit()` - Form edit course
-   `update()` - Update course
-   `destroy()` - Delete course
-   `assignClasses()` - Assign course ke kelas

**Test Cases (15-20 tests):**

#### CRUD Operations

-   ✅ Teacher dapat melihat list courses miliknya
-   ✅ Teacher dapat create course baru
-   ✅ Course disimpan dengan data yang benar
-   ✅ Validasi title required
-   ✅ Validasi category required
-   ✅ Teacher dapat view detail course
-   ✅ Teacher dapat edit course miliknya
-   ✅ Teacher tidak bisa edit course teacher lain
-   ✅ Teacher dapat update course
-   ✅ Teacher dapat delete course miliknya
-   ✅ Teacher tidak bisa delete course teacher lain

#### Assign Classes

-   ✅ Teacher dapat assign course ke multiple classes
-   ✅ Assigned classes tersimpan dengan benar
-   ✅ Validasi class_id required

#### Authorization

-   ✅ Student tidak bisa akses course management
-   ✅ Guest di-redirect ke login

**Priority:** ⭐⭐⭐⭐⭐

---

### 📁 File: `tests/Feature/Teacher/LessonControllerTest.php`

**Method yang Ditest:**

-   `store()` - Create lesson dalam course
-   `destroy()` - Delete lesson

**Test Cases (10-12 tests):**

#### Create Lesson

-   ✅ Teacher dapat create lesson dalam course miliknya
-   ✅ Lesson tersimpan dengan data yang benar
-   ✅ Order sequence otomatis di-set
-   ✅ Validasi title required
-   ✅ Validasi type required (video/quiz)
-   ✅ Validasi content_url required
-   ✅ Teacher tidak bisa create lesson di course teacher lain

#### Delete Lesson

-   ✅ Teacher dapat delete lesson di course miliknya
-   ✅ Teacher tidak bisa delete lesson di course teacher lain
-   ✅ Lesson benar-benar terhapus dari database

#### Authorization

-   ✅ Student tidak bisa create/delete lesson
-   ✅ Guest di-redirect ke login

**Priority:** ⭐⭐⭐⭐⭐

---

### 📁 File: `tests/Feature/Teacher/StudentControllerTest.php`

**Method yang Ditest:**

-   `index()` - List students
-   `create()` - Form create student
-   `store()` - Create student baru
-   `destroy()` - Delete student

**Test Cases (12-15 tests):**

#### List Students

-   ✅ Teacher dapat melihat list students
-   ✅ Students di-filter by class jika ada parameter
-   ✅ Students ditampilkan dengan data lengkap (name, email, class)

#### Create Student

-   ✅ Teacher dapat create student baru
-   ✅ Student tersimpan dengan role 'student'
-   ✅ Password di-hash dengan benar
-   ✅ Validasi name required
-   ✅ Validasi email required & unique
-   ✅ Validasi email format
-   ✅ Validasi password required & min 8 characters
-   ✅ Validasi class_id required

#### Delete Student

-   ✅ Teacher dapat delete student
-   ✅ Student benar-benar terhapus

#### Authorization

-   ✅ Student tidak bisa manage students
-   ✅ Guest di-redirect ke login

**Priority:** ⭐⭐⭐⭐

---

### 📁 File: `tests/Feature/Teacher/PromotionControllerTest.php`

**Method yang Ditest:**

-   `index()` - Halaman promotion
-   `process()` - Proses promosi siswa ke kelas berikutnya

**Test Cases (8-10 tests):**

#### View Promotion Page

-   ✅ Teacher dapat akses halaman promotion
-   ✅ Halaman menampilkan list kelas yang ada

#### Process Promotion

-   ✅ Teacher dapat promote students dari satu kelas ke kelas lain
-   ✅ Students ter-update dengan class_id baru
-   ✅ Hanya students yang dipilih yang di-promote
-   ✅ Validasi from_class_id required
-   ✅ Validasi to_class_id required
-   ✅ Validasi student_ids required

#### Authorization

-   ✅ Student tidak bisa akses promotion
-   ✅ Guest di-redirect ke login

**Priority:** ⭐⭐⭐

---

## 3. Student Controller Tests

### 📁 File: `tests/Feature/Student/DashboardControllerTest.php`

**Method yang Ditest:**

-   `index()` - Dashboard student dengan list courses

**Test Cases (5-6 tests):**

-   ✅ Student dapat akses dashboard
-   ✅ Dashboard menampilkan courses sesuai class student
-   ✅ Dashboard menampilkan progress student
-   ✅ Dashboard tidak menampilkan courses dari class lain
-   ✅ Teacher tidak bisa akses student dashboard
-   ✅ Guest di-redirect ke login

**Priority:** ⭐⭐⭐⭐

---

### 📁 File: `tests/Feature/Student/LessonControllerTest.php`

**Method yang Ditest:**

-   `show()` - Menampilkan lesson (video/quiz)
-   `submitQuiz()` - Submit jawaban quiz

**Test Cases (15-18 tests):**

#### View Lesson

-   ✅ Student dapat akses lesson dari course yang ter-assign ke classnya
-   ✅ Student tidak bisa akses lesson dari course yang tidak ter-assign
-   ✅ Lesson video menampilkan video player
-   ✅ Lesson quiz menampilkan questions dan options
-   ✅ Progress tercatat ketika student akses lesson

#### Submit Quiz

-   ✅ Student dapat submit quiz dengan jawaban yang benar
-   ✅ Score dihitung dengan benar
-   ✅ Progress tersimpan dengan status completed
-   ✅ Student mendapat feedback score setelah submit
-   ✅ Validasi answers required
-   ✅ Validasi format answers (array of question_id => option_id)
-   ✅ Quiz hanya bisa disubmit sekali (atau sesuai business rule)

#### Authorization

-   ✅ Student tidak bisa akses lesson yang bukan dari classnya
-   ✅ Teacher tidak bisa akses student lesson view
-   ✅ Guest di-redirect ke login

#### Edge Cases

-   ✅ Handle ketika lesson tidak ditemukan
-   ✅ Handle ketika quiz tidak memiliki questions
-   ✅ Handle invalid option_id dalam jawaban

**Priority:** ⭐⭐⭐⭐⭐

---

## 4. Model Tests (Unit Tests)

### 📁 File: `tests/Unit/UserModelTest.php`

**Test Cases (10-12 tests):**

#### Relationships

-   ✅ User belongsTo SchoolClass
-   ✅ User hasMany StudentProgress
-   ✅ User hasMany Courses (teacher)
-   ✅ Relationship returns correct instance

#### Attributes & Casting

-   ✅ Password di-hash otomatis
-   ✅ Email verified at di-cast ke datetime
-   ✅ Fillable attributes dapat di-mass assign
-   ✅ Hidden attributes tidak muncul di JSON

#### Scopes/Methods (jika ada)

-   ✅ Method untuk check isTeacher()
-   ✅ Method untuk check isStudent()

**Priority:** ⭐⭐⭐

---

### 📁 File: `tests/Unit/CourseModelTest.php`

**Test Cases (8-10 tests):**

#### Relationships

-   ✅ Course belongsTo User (teacher)
-   ✅ Course belongsToMany SchoolClass (dengan pivot)
-   ✅ Course hasMany Lessons
-   ✅ Lessons diurutkan berdasarkan order_sequence

#### Attributes

-   ✅ Fillable attributes dapat di-mass assign
-   ✅ Slug di-generate otomatis (jika ada observer)

#### Methods

-   ✅ Method untuk get total lessons count
-   ✅ Method untuk get total duration

**Priority:** ⭐⭐⭐

---

### 📁 File: `tests/Unit/LessonModelTest.php`

**Test Cases (8-10 tests):**

#### Relationships

-   ✅ Lesson belongsTo Course
-   ✅ Lesson hasMany Questions
-   ✅ Lesson hasMany StudentProgress

#### Attributes

-   ✅ Fillable attributes dapat di-mass assign
-   ✅ Type enum values (video/quiz)

#### Methods

-   ✅ Method untuk get formatted duration
-   ✅ Method untuk check isVideo()
-   ✅ Method untuk check isQuiz()

**Priority:** ⭐⭐⭐

---

### 📁 File: `tests/Unit/QuestionModelTest.php`

**Test Cases (6-8 tests):**

#### Relationships

-   ✅ Question belongsTo Lesson
-   ✅ Question hasMany Options

#### Attributes

-   ✅ Fillable attributes dapat di-mass assign

#### Methods

-   ✅ Method untuk get correct option
-   ✅ Method untuk check answer

**Priority:** ⭐⭐⭐

---

### 📁 File: `tests/Unit/StudentProgressModelTest.php`

**Test Cases (6-8 tests):**

#### Relationships

-   ✅ StudentProgress belongsTo User
-   ✅ StudentProgress belongsTo Lesson

#### Attributes

-   ✅ Fillable attributes dapat di-mass assign
-   ✅ Status enum values

#### Methods

-   ✅ Method untuk calculate completion percentage
-   ✅ Method untuk check isCompleted()

**Priority:** ⭐⭐⭐

---

## 5. Middleware Tests

### 📁 File: `tests/Feature/CheckRoleMiddlewareTest.php`

**Test Cases (10-12 tests):**

#### Teacher Routes Protection

-   ✅ Teacher dapat akses teacher routes
-   ✅ Student tidak bisa akses teacher routes (403/redirect)
-   ✅ Guest tidak bisa akses teacher routes (redirect to login)

#### Student Routes Protection

-   ✅ Student dapat akses student routes
-   ✅ Teacher tidak bisa akses student routes (403/redirect)
-   ✅ Guest tidak bisa akses student routes (redirect to login)

#### Edge Cases

-   ✅ User dengan role null/undefined di-block
-   ✅ User dengan role tidak valid di-block
-   ✅ Middleware bekerja pada semua protected routes

**Priority:** ⭐⭐⭐⭐⭐

---

## 6. Database Tests

### 📁 File: `tests/Feature/DatabaseSeederTest.php`

**Test Cases (5-6 tests):**

-   ✅ Seeder membuat admin/teacher default
-   ✅ Seeder membuat sample classes
-   ✅ Seeder membuat sample students
-   ✅ Seeder membuat sample courses
-   ✅ Data seeder valid dan dapat digunakan

**Priority:** ⭐⭐

---

### 📁 File: `tests/Feature/MigrationTest.php`

**Test Cases (8-10 tests):**

-   ✅ Migration membuat table users dengan kolom yang benar
-   ✅ Migration membuat table courses dengan kolom yang benar
-   ✅ Migration membuat table lessons dengan kolom yang benar
-   ✅ Migration membuat table questions dengan kolom yang benar
-   ✅ Migration membuat foreign keys yang benar
-   ✅ Migration rollback bekerja dengan benar

**Priority:** ⭐⭐

---

## 7. Integration Tests

### 📁 File: `tests/Feature/CourseCreationFlowTest.php`

**Skenario:** Teacher membuat course lengkap dengan lessons dan quiz

**Test Cases (5-8 tests):**

-   ✅ Teacher create course → success
-   ✅ Teacher assign course ke classes → success
-   ✅ Teacher create video lesson → success
-   ✅ Teacher create quiz lesson dengan questions → success
-   ✅ Student dari class yang ter-assign dapat akses course → success
-   ✅ Student dari class lain tidak dapat akses course → blocked
-   ✅ Student dapat complete lesson dan progress tercatat → success

**Priority:** ⭐⭐⭐⭐

---

### 📁 File: `tests/Feature/StudentLearningFlowTest.php`

**Skenario:** Student belajar dari dashboard sampai selesai quiz

**Test Cases (8-10 tests):**

-   ✅ Student login → dashboard → list courses
-   ✅ Student pilih course → list lessons
-   ✅ Student akses video lesson → progress tercatat
-   ✅ Student akses quiz → questions ditampilkan
-   ✅ Student submit quiz → score dihitung
-   ✅ Student submit quiz → progress updated
-   ✅ Dashboard menampilkan course yang sedang dipelajari
-   ✅ Dashboard menampilkan progress percentage

**Priority:** ⭐⭐⭐⭐

---

### 📁 File: `tests/Feature/PromotionFlowTest.php`

**Skenario:** Teacher melakukan promosi students ke kelas berikutnya

**Test Cases (6-8 tests):**

-   ✅ Teacher pilih class asal dan tujuan
-   ✅ Teacher pilih students yang akan dipromote
-   ✅ Promotion diproses dengan benar
-   ✅ Students ter-update dengan class baru
-   ✅ Students mendapat akses ke courses class baru
-   ✅ Students tidak lagi akses courses class lama

**Priority:** ⭐⭐⭐

---

## 📋 Ringkasan Test Coverage

| Kategori            | File Tests | Jumlah Test Cases | Priority   |
| ------------------- | ---------- | ----------------- | ---------- |
| Authentication      | 1 file     | 17-18 tests       | ⭐⭐⭐⭐⭐ |
| Teacher Controllers | 5 files    | 50-60 tests       | ⭐⭐⭐⭐⭐ |
| Student Controllers | 2 files    | 20-24 tests       | ⭐⭐⭐⭐⭐ |
| Models              | 5 files    | 40-50 tests       | ⭐⭐⭐     |
| Middleware          | 1 file     | 10-12 tests       | ⭐⭐⭐⭐⭐ |
| Database            | 2 files    | 13-16 tests       | ⭐⭐       |
| Integration         | 3 files    | 19-26 tests       | ⭐⭐⭐⭐   |

**TOTAL: ~19 test files dengan 169-206 test cases**

---

## 🎯 Rekomendasi Implementasi

### Phase 1: Critical Tests (Minggu 1-2)

**Target: 60-70 tests**

1. ✅ **AuthControllerTest** (17-18 tests) - SUDAH ADA PLANNING
2. ✅ **CheckRoleMiddlewareTest** (10-12 tests)
3. ✅ **Teacher/CourseControllerTest** (15-20 tests)
4. ✅ **Teacher/LessonControllerTest** (10-12 tests)
5. ✅ **Student/LessonControllerTest** (15-18 tests)

### Phase 2: Important Tests (Minggu 3-4)

**Target: 50-60 tests**

1. ✅ **Teacher/DashboardControllerTest** (3-4 tests)
2. ✅ **Student/DashboardControllerTest** (5-6 tests)
3. ✅ **Teacher/StudentControllerTest** (12-15 tests)
4. ✅ **CourseCreationFlowTest** (5-8 tests)
5. ✅ **StudentLearningFlowTest** (8-10 tests)
6. ✅ **CourseModelTest** (8-10 tests)
7. ✅ **LessonModelTest** (8-10 tests)

### Phase 3: Completion Tests (Minggu 5-6)

**Target: 60-80 tests**

1. ✅ **Teacher/PromotionControllerTest** (8-10 tests)
2. ✅ **PromotionFlowTest** (6-8 tests)
3. ✅ **UserModelTest** (10-12 tests)
4. ✅ **QuestionModelTest** (6-8 tests)
5. ✅ **StudentProgressModelTest** (6-8 tests)
6. ✅ **DatabaseSeederTest** (5-6 tests)
7. ✅ **MigrationTest** (8-10 tests)

---

## 🛠️ Tools & Setup Required

### 1. PHPUnit Configuration

```xml
<!-- phpunit.xml -->
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
<env name="SESSION_DRIVER" value="array"/>
<env name="CACHE_DRIVER" value="array"/>
<env name="QUEUE_CONNECTION" value="sync"/>
```

### 2. Factory Setup

Pastikan semua model memiliki factory:

-   ✅ UserFactory (dengan state teacher & student)
-   ⚠️ CourseFactory (perlu dibuat)
-   ⚠️ LessonFactory (perlu dibuat)
-   ⚠️ QuestionFactory (perlu dibuat)
-   ⚠️ OptionFactory (perlu dibuat)
-   ⚠️ SchoolClassFactory (perlu dibuat)
-   ⚠️ StudentProgressFactory (perlu dibuat)

### 3. Test Database

```bash
# Buat database testing
touch database/database.sqlite

# Atau gunakan in-memory SQLite (recommended)
# Sudah di-config di phpunit.xml
```

### 4. Helper Methods di TestCase.php

```php
// Helper untuk create users with specific role
protected function createTeacher($attributes = [])
protected function createStudent($attributes = [])

// Helper untuk acting as specific role
protected function actingAsTeacher($attributes = [])
protected function actingAsStudent($attributes = [])

// Helper untuk create course dengan lessons
protected function createCourseWithLessons($teacher, $lessonCount = 3)

// Helper untuk assign course ke class
protected function assignCourseToClass($course, $class)
```

---

## 📊 Code Coverage Target

| Component   | Target Coverage |
| ----------- | --------------- |
| Controllers | 90%+            |
| Models      | 85%+            |
| Middleware  | 95%+            |
| Overall     | 85%+            |

---

## ✅ Best Practices

1. **Database Isolation**: Gunakan `RefreshDatabase` trait
2. **AAA Pattern**: Arrange, Act, Assert
3. **Descriptive Names**: test method names yang jelas
4. **One Concept Per Test**: Fokus pada satu hal
5. **DRY Principle**: Gunakan helper methods
6. **Mock External Services**: Jika ada email, notifications, etc
7. **Test Edge Cases**: Happy path + error cases
8. **Fast Tests**: Optimize untuk kecepatan

---

## 🔄 CI/CD Integration

### GitHub Actions Example

```yaml
name: Tests

on: [push, pull_request]

jobs:
    test:
        runs-on: ubuntu-latest
        steps:
            - uses: actions/checkout@v2
            - name: Setup PHP
              uses: shivammathur/setup-php@v2
              with:
                  php-version: 8.2
            - name: Install Dependencies
              run: composer install
            - name: Run Tests
              run: php artisan test --coverage --min=85
```

---

## 📝 Checklist Implementasi

### Setup

-   [ ] Update phpunit.xml dengan config testing
-   [ ] Buat factories untuk semua models
-   [ ] Buat helper methods di TestCase.php
-   [ ] Setup CI/CD untuk auto-run tests

### Phase 1: Critical Tests

-   [ ] AuthControllerTest
-   [ ] CheckRoleMiddlewareTest
-   [ ] Teacher/CourseControllerTest
-   [ ] Teacher/LessonControllerTest
-   [ ] Student/LessonControllerTest

### Phase 2: Important Tests

-   [ ] Dashboard Tests (Teacher & Student)
-   [ ] Teacher/StudentControllerTest
-   [ ] Integration Flow Tests
-   [ ] Model Tests (Course, Lesson)

### Phase 3: Completion

-   [ ] Teacher/PromotionControllerTest
-   [ ] Remaining Model Tests
-   [ ] Database Tests
-   [ ] Achieve 85%+ coverage

---

## 🎓 Learning Resources

-   [Laravel Testing Documentation](https://laravel.com/docs/testing)
-   [PHPUnit Documentation](https://phpunit.de/documentation.html)
-   [Test Driven Development (TDD)](https://www.guru99.com/test-driven-development.html)
-   [Laravel HTTP Tests](https://laravel.com/docs/http-tests)
-   [Database Testing](https://laravel.com/docs/database-testing)

---

**Dibuat:** 2025-12-10  
**Project:** EduStream LMS  
**Total Estimasi Test Cases:** 169-206 tests  
**Total Estimasi Waktu:** 6-8 minggu (untuk complete coverage)
