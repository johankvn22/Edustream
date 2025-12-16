# Perencanaan Unit Test untuk AuthController

Dokumen ini berisi perencanaan lengkap untuk membuat unit test menggunakan PHPUnit untuk `AuthController` pada aplikasi EduStream.

## Analisis AuthController

AuthController memiliki 5 method public yang perlu ditest:

1. **`showLanding()`** - Menampilkan halaman landing / redirect jika sudah login
2. **`showLogin()`** - Menampilkan form login / redirect jika sudah login
3. **`login()`** - Menangani proses login dengan validasi dan role-based redirect
4. **`logout()`** - Menangani proses logout
5. **`redirectBasedOnRole()`** - Private method untuk redirect berdasarkan role (akan ditest secara tidak langsung)

## Hal yang Perlu Dikonfirmasi

> **PENTING - Perlu Konfirmasi:**
>
> 1. Apakah sudah ada database testing atau perlu setup database untuk testing?
> 2. Apakah perlu test untuk validation error messages dalam bahasa Indonesia?
> 3. Apakah ada middleware yang perlu dimock dalam test (misalnya rate limiting)?

## File yang Akan Dibuat/Dimodifikasi

### 1. File Test Utama (BARU)

**Make Test** php artisan make:test NAMA TEST

**File:** `tests/Feature/AuthControllerTest.php`

File test utama yang akan berisi semua test cases untuk AuthController. Test ini akan menggunakan:

-   `RefreshDatabase` trait untuk reset database setiap test
-   Factory untuk membuat user dummy
-   HTTP testing dari Laravel untuk simulasi request/response

**Test Cases yang akan dibuat (17-18 tests):**

#### A. Test Landing Page (3 tests)

-   `test_landing_page_accessible_for_guest()` - Guest bisa akses landing page
-   `test_landing_page_redirects_authenticated_teacher()` - Teacher login redirect ke dashboard teacher
-   `test_landing_page_redirects_authenticated_student()` - Student login redirect ke dashboard student

#### B. Test Login Form (2 tests)

-   `test_login_page_accessible_for_guest()` - Guest bisa akses login page
-   `test_login_page_redirects_authenticated_user()` - User sudah login redirect ke dashboard sesuai role

#### C. Test Login Process (9 tests)

-   `test_user_can_login_with_valid_credentials()` - Login berhasil dengan credentials valid
-   `test_teacher_redirected_to_teacher_dashboard_after_login()` - Teacher redirect ke teacher dashboard
-   `test_student_redirected_to_student_dashboard_after_login()` - Student redirect ke student dashboard
-   `test_login_fails_with_invalid_email()` - Login gagal dengan email salah
-   `test_login_fails_with_invalid_password()` - Login gagal dengan password salah
-   `test_login_fails_with_missing_email()` - Validasi email required
-   `test_login_fails_with_missing_password()` - Validasi password required
-   `test_login_fails_with_invalid_email_format()` - Validasi format email
-   `test_session_regenerated_after_successful_login()` - Session regenerate setelah login

#### D. Test Logout Process (3-4 tests)

-   `test_authenticated_user_can_logout()` - User bisa logout
-   `test_session_invalidated_after_logout()` - Session dihapus setelah logout
-   `test_user_redirected_to_landing_after_logout()` - Redirect ke landing setelah logout
-   `test_guest_cannot_access_logout()` - Guest tidak bisa akses logout (opsional, jika ada middleware)

#### E. Test Role-Based Redirect

-   `test_user_with_unknown_role_redirected_with_error()` - User dengan role tidak valid
-   Test lainnya sudah tercakup dalam test login dan landing page

---

### 2. Konfigurasi PHPUnit (MODIFIKASI)

**File:** `phpunit.xml`

Pastikan konfigurasi PHPUnit sudah benar dengan environment variable untuk testing:

        <env name="APP_ENV" value="testing"/>
        <env name="APP_MAINTENANCE_DRIVER" value="file"/>
        <env name="BCRYPT_ROUNDS" value="4"/>
        <env name="CACHE_STORE" value="array"/>
        <env name="DB_CONNECTION" value="mysql"/>
        <env name="DB_DATABASE" value="laravel_testing"/>
        <env name="MAIL_MAILER" value="array"/>
        <env name="PULSE_ENABLED" value="false"/>
        <env name="QUEUE_CONNECTION" value="sync"/>
        <env name="SESSION_DRIVER" value="array"/>
        <env name="TELESCOPE_ENABLED" value="false"/>

---

### 3. User Factory (MODIFIKASI/CEK)

**File:** `database/factories/UserFactory.php`

Memastikan UserFactory sudah support untuk membuat user dengan role teacher dan student untuk keperluan testing.

Contoh yang diperlukan:

```php
public function teacher()
{
    return $this->state(fn (array $attributes) => [
        'role' => 'teacher',
    ]);
}

public function student()
{
    return $this->state(fn (array $attributes) => [
        'role' => 'student',
    ]);
}
```

---

### 4. Helper Methods (MODIFIKASI)

**File:** `tests/TestCase.php`

Menambahkan helper methods yang bisa digunakan untuk semua test:

```php
protected function createTeacher(array $attributes = [])
{
    return User::factory()->teacher()->create($attributes);
}

protected function createStudent(array $attributes = [])
{
    return User::factory()->student()->create($attributes);
}

protected function actingAsTeacher(array $attributes = [])
{
    return $this->actingAs($this->createTeacher($attributes));
}

protected function actingAsStudent(array $attributes = [])
{
    return $this->actingAs($this->createStudent($attributes));
}
```

## Struktur Test yang Akan Dibuat

```
tests/
├── Feature/
│   ├── AuthControllerTest.php (BARU - ~400-500 lines)
│   └── ExampleTest.php (sudah ada)
├── Unit/
│   └── ExampleTest.php (sudah ada)
└── TestCase.php (MODIFIKASI - tambah helper methods)
```

## Detail Test Coverage

| Method                  | Jumlah Test | Coverage Yang Ditest                                  |
| ----------------------- | ----------- | ----------------------------------------------------- |
| `showLanding()`         | 3 tests     | Guest access, Teacher redirect, Student redirect      |
| `showLogin()`           | 2 tests     | Guest access, Authenticated redirect                  |
| `login()`               | 9 tests     | Valid login, Invalid credentials, Validation, Session |
| `logout()`              | 3-4 tests   | Successful logout, Session cleanup, Redirect          |
| `redirectBasedOnRole()` | Indirect    | Tested via login dan landing page tests               |

**Total: 17-18 test cases**

**Target Coverage: 90%+ untuk AuthController**

## Rencana Verifikasi

### Automated Tests

1. **Menjalankan semua test:**

    ```bash
    php artisan test
    ```

2. **Menjalankan test untuk AuthController saja:**

    ```bash
    php artisan test --filter=AuthControllerTest
    ```

3. **Menjalankan test dengan coverage report:**

    ```bash
    php artisan test --coverage
    ```

    Atau dengan detailed coverage:

    ```bash
    php artisan test --coverage --min=90
    ```

4. **Test individual method:**

    ```bash
    php artisan test --filter=test_user_can_login_with_valid_credentials
    ```

5. **Test dengan output verbose:**
    ```bash
    php artisan test --filter=AuthControllerTest -v
    ```

### Manual Verification

1. ✅ Memastikan semua test cases passed (hijau)
2. ✅ Memeriksa code coverage untuk AuthController mencapai minimal 90%
3. ✅ Verifikasi tidak ada side effects ke database development
4. ✅ Memastikan test berjalan dalam isolasi (tidak saling mempengaruhi)
5. ✅ Cek tidak ada error/warning saat menjalankan test

## Langkah Implementasi (Step by Step)

### Fase 1: Setup & Preparation (15-30 menit)

1. **Verifikasi PHPUnit:**

    ```bash
    php artisan test
    ```

2. **Setup database testing:**

    - Update `phpunit.xml` dengan konfigurasi database testing
    - Gunakan SQLite in-memory untuk testing yang cepat

3. **Cek dependencies:**
    - Pastikan semua routes sudah terdaftar (teacher.dashboard, student.dashboard)
    - Pastikan User model sudah ada

### Fase 2: Create Helper Methods (15 menit)

1. Update `tests/TestCase.php` dengan helper methods:

    - `createTeacher()`
    - `createStudent()`
    - `actingAsTeacher()`
    - `actingAsStudent()`

2. Update `database/factories/UserFactory.php` jika diperlukan:
    - Tambah state `teacher()`
    - Tambah state `student()`

### Fase 3: Implement Test Cases

#### Langkah 3.1: Landing & Login Page Tests (30-45 menit)

Buat file `tests/Feature/AuthControllerTest.php` dan implement:

-   ✅ `test_landing_page_accessible_for_guest()`
-   ✅ `test_landing_page_redirects_authenticated_teacher()`
-   ✅ `test_landing_page_redirects_authenticated_student()`
-   ✅ `test_login_page_accessible_for_guest()`
-   ✅ `test_login_page_redirects_authenticated_user()`

**Run test:**

```bash
php artisan test --filter=AuthControllerTest
```

#### Langkah 3.2: Login Process Tests (45-60 menit)

Implement login tests:

-   ✅ `test_user_can_login_with_valid_credentials()`
-   ✅ `test_teacher_redirected_to_teacher_dashboard_after_login()`
-   ✅ `test_student_redirected_to_student_dashboard_after_login()`
-   ✅ `test_login_fails_with_invalid_email()`
-   ✅ `test_login_fails_with_invalid_password()`
-   ✅ `test_login_fails_with_missing_email()`
-   ✅ `test_login_fails_with_missing_password()`
-   ✅ `test_login_fails_with_invalid_email_format()`
-   ✅ `test_session_regenerated_after_successful_login()`

**Run test:**

```bash
php artisan test --filter=AuthControllerTest
```

#### Langkah 3.3: Logout Tests (30 menit)

Implement logout tests:

-   ✅ `test_authenticated_user_can_logout()`
-   ✅ `test_session_invalidated_after_logout()`
-   ✅ `test_user_redirected_to_landing_after_logout()`
-   ✅ `test_user_with_unknown_role_redirected_with_error()`

**Run test:**

```bash
php artisan test --filter=AuthControllerTest
```

### Fase 4: Testing & Debugging (30-45 menit)

1. **Run semua test:**

    ```bash
    php artisan test
    ```

2. **Fix failing tests** jika ada

3. **Check coverage:**

    ```bash
    php artisan test --coverage
    ```

4. **Refactor** jika diperlukan untuk improve code quality

### Fase 5: Documentation (15 menit)

1. Tambahkan docblock untuk setiap test method
2. Update README.md jika diperlukan dengan cara menjalankan test
3. Commit dengan message yang jelas

## Estimasi Waktu Total

| Fase                               | Estimasi Waktu |
| ---------------------------------- | -------------- |
| Setup & Preparation                | 15-30 menit    |
| Helper Methods                     | 15 menit       |
| Test Fase 1 (Landing & Login Page) | 30-45 menit    |
| Test Fase 2 (Login Process)        | 45-60 menit    |
| Test Fase 3 (Logout)               | 30 menit       |
| Testing & Debugging                | 30-45 menit    |
| Documentation                      | 15 menit       |

**Total: 2.5 - 3.5 jam**

## Dependency & Requirements

-   ✅ PHPUnit (sudah terinstall via Laravel)
-   ✅ Laravel Testing Tools (sudah built-in)
-   ⚠️ Database Testing (perlu konfirmasi setup - recommend SQLite)
-   ⚠️ User Factory dengan role support (perlu cek/update)
-   ⚠️ Routes untuk teacher.dashboard dan student.dashboard (perlu ada)

## Best Practices yang Akan Diterapkan

### 1. AAA Pattern (Arrange, Act, Assert)

```php
public function test_example()
{
    // Arrange - Setup data
    $user = User::factory()->create();

    // Act - Lakukan aksi
    $response = $this->post('/login', [...]);

    // Assert - Verifikasi hasil
    $response->assertRedirect('/dashboard');
}
```

### 2. Descriptive Test Names

-   Gunakan snake_case
-   Nama test harus jelas mendeskripsikan apa yang ditest
-   Format: `test_[what]_[condition]_[expected_result]()`

### 3. One Assertion Per Concept

-   Fokus pada satu hal per test
-   Jika perlu multiple assertions, pastikan mereka test concept yang sama

### 4. Database Isolation

```php
use RefreshDatabase;
```

-   Setiap test tidak saling mempengaruhi
-   Database direset setelah setiap test

### 5. DRY Principle

-   Gunakan helper methods untuk code reuse
-   Gunakan setUp() untuk setup yang berulang
-   Extract common logic ke TestCase

### 6. Comprehensive Coverage

-   Test happy path (success cases)
-   Test edge cases (boundary conditions)
-   Test error cases (validation, authentication failures)

## Contoh Struktur Test

```php
<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function landing_page_accessible_for_guest()
    {
        // Arrange - tidak perlu setup khusus

        // Act
        $response = $this->get('/');

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('landing');
    }

    /** @test */
    public function user_can_login_with_valid_credentials()
    {
        // Arrange
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'role' => 'teacher'
        ]);

        // Act
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        // Assert
        $response->assertRedirect('/teacher/dashboard');
        $this->assertAuthenticatedAs($user);
    }
}
```

## Checklist Implementasi

-   [ ] Fase 1: Setup & Preparation
    -   [ ] Verifikasi PHPUnit berjalan
    -   [ ] Update phpunit.xml
    -   [ ] Cek routes tersedia
-   [ ] Fase 2: Helper Methods
    -   [ ] Update TestCase.php
    -   [ ] Update/cek UserFactory.php
-   [ ] Fase 3.1: Landing & Login Page Tests (5 tests)
    -   [ ] test_landing_page_accessible_for_guest
    -   [ ] test_landing_page_redirects_authenticated_teacher
    -   [ ] test_landing_page_redirects_authenticated_student
    -   [ ] test_login_page_accessible_for_guest
    -   [ ] test_login_page_redirects_authenticated_user
-   [ ] Fase 3.2: Login Process Tests (9 tests)
    -   [ ] test_user_can_login_with_valid_credentials
    -   [ ] test_teacher_redirected_to_teacher_dashboard_after_login
    -   [ ] test_student_redirected_to_student_dashboard_after_login
    -   [ ] test_login_fails_with_invalid_email
    -   [ ] test_login_fails_with_invalid_password
    -   [ ] test_login_fails_with_missing_email
    -   [ ] test_login_fails_with_missing_password
    -   [ ] test_login_fails_with_invalid_email_format
    -   [ ] test_session_regenerated_after_successful_login
-   [ ] Fase 3.3: Logout Tests (4 tests)
    -   [ ] test_authenticated_user_can_logout
    -   [ ] test_session_invalidated_after_logout
    -   [ ] test_user_redirected_to_landing_after_logout
    -   [ ] test_user_with_unknown_role_redirected_with_error
-   [ ] Fase 4: Testing & Debugging
    -   [ ] Run semua test dan pastikan passed
    -   [ ] Check coverage
    -   [ ] Fix failing tests
    -   [ ] Refactor
-   [ ] Fase 5: Documentation
    -   [ ] Tambah docblock
    -   [ ] Update README
    -   [ ] Commit changes

## Troubleshooting Common Issues

### Issue 1: Database Connection Error

**Solusi:** Pastikan `phpunit.xml` sudah config dengan benar:

**File:** `phpunit.xml`

Pastikan konfigurasi PHPUnit sudah benar dengan environment variable untuk testing:

```xml
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
<env name="SESSION_DRIVER" value="array"/>
<env name="CACHE_DRIVER" value="array"/>
```

### Issue 2: Routes Not Found

**Solusi:** Pastikan routes sudah terdaftar dengan name yang benar dalam `routes/web.php`

### Issue 3: Factory Error

**Solusi:** Run migrations untuk test database:

```bash
php artisan migrate --env=testing
```

### Issue 4: Session Not Working

**Solusi:** Pastikan session driver untuk testing:

```xml
<env name="SESSION_DRIVER" value="array"/>
```

## Resources & Referensi

-   [Laravel Testing Documentation](https://laravel.com/docs/testing)
-   [PHPUnit Documentation](https://phpunit.de/documentation.html)
-   [Laravel HTTP Tests](https://laravel.com/docs/http-tests)
-   [Laravel Database Testing](https://laravel.com/docs/database-testing)

---

**Dibuat:** 2025-12-10  
**Untuk:** EduStream - AuthController Unit Testing  
**Teknologi:** Laravel, PHPUnit
