# Feature Test vs Unit Test - Penjelasan Lengkap

Dokumen ini menjelaskan perbedaan antara **Feature Test** dan **Unit Test** dalam Laravel dengan contoh praktis dari AuthController.

---

## 📚 Definisi

### Unit Test

**Unit Test** adalah pengujian yang fokus pada **satu unit kecil kode secara isolated** (biasanya satu method atau function). Unit test:

-   Test logic murni tanpa dependencies eksternal
-   Mock semua dependencies (database, HTTP, external services)
-   Sangat cepat karena tidak ada I/O operations
-   Fokus pada "apakah logic ini benar?"

### Feature Test

**Feature Test** adalah pengujian yang test **fitur aplikasi secara keseluruhan** dari perspektif user. Feature test:

-   Test full HTTP request/response cycle
-   Menggunakan database (dengan RefreshDatabase)
-   Test integrasi antar komponen
-   Fokus pada "apakah fitur ini bekerja dari user perspective?"

---

## 🔄 Perbandingan Langsung

| Aspek            | Unit Test              | Feature Test                        |
| ---------------- | ---------------------- | ----------------------------------- |
| **Scope**        | Single method/function | Entire feature/request cycle        |
| **Dependencies** | Mocked/Stubbed         | Real (database, routes, middleware) |
| **Database**     | Tidak hit database     | Hit database (RefreshDatabase)      |
| **HTTP**         | No HTTP requests       | Full HTTP request/response          |
| **Speed**        | Sangat cepat (ms)      | Lebih lambat (100ms+)               |
| **Isolation**    | Completely isolated    | Integrated components               |
| **Folder**       | `tests/Unit/`          | `tests/Feature/`                    |
| **Purpose**      | Test logic correctness | Test feature works end-to-end       |

---

## 🎯 Kapan Menggunakan Unit Test?

Gunakan **Unit Test** ketika:

-   ✅ Test business logic yang kompleks
-   ✅ Test calculations, transformations, validators
-   ✅ Test methods yang tidak depend pada framework
-   ✅ Test pure functions atau helper functions
-   ✅ Ingin test sangat cepat untuk TDD cycle

**Contoh yang cocok untuk Unit Test:**

-   Helper functions (formatting, parsing)
-   Business logic di Service classes
-   Custom validators
-   Data transformations
-   Calculations (pricing, discounts, taxes)

---

## 🎯 Kapan Menggunakan Feature Test?

Gunakan **Feature Test** ketika:

-   ✅ Test HTTP endpoints (GET, POST, PUT, DELETE)
-   ✅ Test authentication & authorization
-   ✅ Test full user workflows
-   ✅ Test database interactions
-   ✅ Test middleware behavior
-   ✅ Test view rendering

**Contoh yang cocok untuk Feature Test:**

-   Login, logout, registration
-   CRUD operations
-   Form submissions
-   API endpoints
-   User workflows (checkout, booking, etc)

---

## 💡 Contoh Praktis: AuthController

Mari bandingkan testing untuk `AuthController` dengan kedua approach:

### 1. Unit Test Approach

```php
// tests/Unit/AuthControllerUnitTest.php

public function test_redirect_based_on_role_returns_teacher_dashboard_for_teacher(): void
{
    // Arrange - Buat user manually
    $teacher = User::factory()->create(['role' => 'teacher']);

    // Act - Panggil method directly dengan reflection
    $reflection = new \ReflectionClass($this->controller);
    $method = $reflection->getMethod('redirectBasedOnRole');
    $method->setAccessible(true);

    $result = $method->invoke($this->controller, $teacher);

    // Assert - Check return value
    $this->assertInstanceOf(RedirectResponse::class, $result);
    $this->assertEquals(route('teacher.dashboard'), $result->getTargetUrl());
}
```

**Karakteristik Unit Test:**

-   ❌ **Tidak test HTTP** - Panggil method langsung
-   ❌ **Tidak test middleware** - Bypass semuanya
-   ❌ **Tidak test routing** - Langsung ke method
-   ✅ **Test logic murni** - Apakah redirect ke route yang benar?
-   ✅ **Sangat cepat** - No overhead
-   ⚠️ **Perlu reflection** untuk private methods

---

### 2. Feature Test Approach

```php
// tests/Feature/AuthControllerTest.php

public function test_teacher_redirected_to_teacher_dashboard_after_login(): void
{
    // Arrange - Buat user di database
    $teacher = User::factory()->create([
        'email' => 'teacher@test.com',
        'password' => bcrypt('password123'),
        'role' => 'teacher'
    ]);

    // Act - Simulate HTTP POST request
    $response = $this->post('/login', [
        'email' => 'teacher@test.com',
        'password' => 'password123'
    ]);

    // Assert - Check HTTP response
    $response->assertRedirect('/teacher/dashboard');
    $this->assertAuthenticatedAs($teacher);
}
```

**Karakteristik Feature Test:**

-   ✅ **Test HTTP request** - POST /login
-   ✅ **Test middleware** - Auth, CSRF protection
-   ✅ **Test routing** - Apakah route benar?
-   ✅ **Test validation** - Email, password validation
-   ✅ **Test session** - Authentication state
-   ✅ **Test database** - User lookup, credentials check
-   ⚠️ **Lebih lambat** - Banyak komponen involved

---

## 🔍 Contoh Kasus: Login Method

### Unit Test Approach (Dengan Mocking)

```php
public function test_login_authenticates_user_with_valid_credentials(): void
{
    // Arrange
    $user = User::factory()->make(['role' => 'teacher']);
    $request = Mockery::mock(Request::class);

    // Mock validation
    $request->shouldReceive('validate')
        ->once()
        ->with(['email' => 'required|email', 'password' => 'required'])
        ->andReturn(['email' => 'test@test.com', 'password' => 'password']);

    // Mock session
    $session = Mockery::mock();
    $session->shouldReceive('regenerate')->once();
    $request->shouldReceive('session')->andReturn($session);

    // Mock Auth
    Auth::shouldReceive('attempt')
        ->once()
        ->with(['email' => 'test@test.com', 'password' => 'password'])
        ->andReturn(true);

    Auth::shouldReceive('user')
        ->once()
        ->andReturn($user);

    // Act
    $result = $this->controller->login($request);

    // Assert
    $this->assertInstanceOf(RedirectResponse::class, $result);
}
```

**Pros:**

-   ✅ Isolated testing
-   ✅ Sangat cepat
-   ✅ Test logic tanpa dependencies

**Cons:**

-   ❌ Banyak setup mocking
-   ❌ Brittle - Perubahan kecil break test
-   ❌ Tidak test integrasi sebenarnya

---

### Feature Test Approach (End-to-End)

```php
public function test_user_can_login_with_valid_credentials(): void
{
    // Arrange
    $user = User::factory()->create([
        'email' => 'test@test.com',
        'password' => bcrypt('password123'),
        'role' => 'teacher'
    ]);

    // Act
    $response = $this->post('/login', [
        'email' => 'test@test.com',
        'password' => 'password123'
    ]);

    // Assert
    $response->assertRedirect('/teacher/dashboard');
    $this->assertAuthenticatedAs($user);
}
```

**Pros:**

-   ✅ Simple dan readable
-   ✅ Test real integration
-   ✅ Confident fitur bekerja
-   ✅ Test dari user perspective

**Cons:**

-   ⚠️ Sedikit lebih lambat
-   ⚠️ Perlu database setup

---

## 📊 Mocking vs Real Dependencies

### Unit Test - Heavy Mocking

```php
// Mock Auth facade
Auth::shouldReceive('check')
    ->once()
    ->andReturn(false);

// Mock Request
$request = Mockery::mock(Request::class);
$request->shouldReceive('validate')->andReturn([...]);

// Mock Session
$session = Mockery::mock();
$session->shouldReceive('regenerate')->once();
```

**Kelebihan:**

-   Isolated testing
-   Fast execution
-   No side effects

**Kekurangan:**

-   Banyak boilerplate code
-   Bisa jadi overly specific
-   Miss integration bugs

---

### Feature Test - Real Dependencies

```php
// Real HTTP request
$response = $this->post('/login', [...]);

// Real database
User::factory()->create([...]);

// Real Auth system
$this->assertAuthenticated();

// Real session
$response->assertSessionHas('key', 'value');
```

**Kelebihan:**

-   Natural dan simple
-   Test real behavior
-   Catch integration issues

**Kekurangan:**

-   Sedikit lebih lambat
-   Perlu database cleanup (RefreshDatabase)

---

## 🧪 Kombinasi Ideal: Testing Pyramid

```
        /\
       /  \
      / UI \          <- E2E/Browser Tests (sedikit, slow)
     /------\
    /        \
   / Feature \        <- Feature Tests (medium coverage)
  /----------\
 /            \
/  Unit Tests \      <- Unit Tests (banyak, fast)
----------------
```

### Rekomendasi untuk EduStream:

**70% Feature Tests:**

-   AuthController → Feature Test
-   CourseController → Feature Test
-   LessonController → Feature Test
-   StudentController → Feature Test
-   DashboardController → Feature Test

**20% Unit Tests:**

-   Helper functions → Unit Test
-   Service classes → Unit Test
-   Custom validators → Unit Test
-   Business logic calculations → Unit Test

**10% Integration/E2E:**

-   Complete user flows → Integration Test
-   Multi-step workflows → Integration Test

---

## 🎓 Best Practices

### Untuk Unit Tests:

1. **Mock external dependencies**

    ```php
    Auth::shouldReceive('check')->andReturn(true);
    ```

2. **Test one thing at a time**

    ```php
    // ✅ Good - Test satu concept
    public function test_calculate_discount_returns_correct_amount()

    // ❌ Bad - Test banyak hal
    public function test_order_processing()
    ```

3. **Fast execution**

    - No database queries
    - No HTTP requests
    - No file I/O

4. **Isolated**
    - Tidak depend pada test lain
    - Dapat dijalankan dalam urutan apapun

---

### Untuk Feature Tests:

1. **Use RefreshDatabase**

    ```php
    use RefreshDatabase;
    ```

2. **Test dari user perspective**

    ```php
    // ✅ Good
    $response = $this->post('/login', [...]);

    // ❌ Bad (ini unit test)
    $controller->login($request);
    ```

3. **Test happy path + edge cases**

    ```php
    test_user_can_login_with_valid_credentials()
    test_login_fails_with_invalid_password()
    test_login_fails_with_missing_email()
    ```

4. **Descriptive test names**

    ```php
    // ✅ Good
    test_teacher_redirected_to_teacher_dashboard_after_login()

    // ❌ Bad
    test_login()
    ```

---

## 📝 Contoh Spesifik: AuthController

### Yang Sebaiknya Feature Test:

✅ **`AuthControllerTest.php` (Feature)**

```php
- test_user_can_login_with_valid_credentials()
- test_login_fails_with_invalid_password()
- test_authenticated_user_redirected_from_login_page()
- test_user_can_logout()
- test_session_invalidated_after_logout()
```

**Alasan:** Semua ini involve HTTP, routing, middleware, session, database

---

### Yang Bisa Unit Test (Opsional):

⚠️ **`AuthControllerUnitTest.php` (Unit)**

```php
- test_redirect_based_on_role_returns_correct_route()
- test_controller_has_required_methods()
```

**Alasan:** Test logic murni, tapi untuk AuthController ini kurang value karena logicnya simple dan tightly coupled dengan framework

---

## 🎯 Kesimpulan

### Untuk AuthController:

**Rekomendasi: Gunakan Feature Test**

**Alasan:**

1. AuthController sangat depend pada HTTP request/response
2. Logic tidak kompleks, tidak perlu isolated unit test
3. Yang penting adalah: apakah user bisa login? Bukan: apakah method X return Y
4. Feature test lebih readable dan maintainable
5. Feature test catch integration bugs (routing, middleware, session)

### General Rule:

| Situation                     | Use              |
| ----------------------------- | ---------------- |
| Controllers dengan HTTP logic | **Feature Test** |
| Pure business logic           | **Unit Test**    |
| Database operations           | **Feature Test** |
| Helper/Utility functions      | **Unit Test**    |
| Authentication/Authorization  | **Feature Test** |
| API endpoints                 | **Feature Test** |
| Calculations/Transformations  | **Unit Test**    |
| Service classes               | **Unit Test**    |
| Full user workflows           | **Feature Test** |

---

## 📚 Resources

-   [Laravel Testing Documentation](https://laravel.com/docs/testing)
-   [Testing Pyramid by Martin Fowler](https://martinfowler.com/articles/practical-test-pyramid.html)
-   [PHPUnit Documentation](https://phpunit.de/)
-   [Mockery Documentation](http://docs.mockery.io/)

---

## ✅ Checklist: Memilih Test Type

Tanya diri Anda:

-   [ ] Apakah test ini involve HTTP request? → **Feature Test**
-   [ ] Apakah test ini perlu database? → **Feature Test**
-   [ ] Apakah test ini untuk pure logic/calculation? → **Unit Test**
-   [ ] Apakah ini helper/utility function? → **Unit Test**
-   [ ] Apakah test dari perspektif end-user? → **Feature Test**
-   [ ] Apakah test ini perlu mock banyak dependencies? → Mungkin salah approach, coba **Feature Test**
-   [ ] Apakah logic sangat kompleks dan critical? → **Both** (Unit + Feature)

---

**Dibuat:** 2025-12-11  
**Project:** EduStream  
**Topic:** Feature vs Unit Testing Guide
