<?php

namespace Tests\Unit;

use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Tests\TestCase;
use Mockery;

/**
 * Unit Test untuk AuthController
 * 
 * Unit test fokus pada testing logic individual methods secara isolated
 * dengan mocking dependencies (Auth, Request, dll)
 * 
 * Berbeda dengan Feature Test yang test full HTTP request/response cycle
 * 
 * CATATAN PENTING:
 * - Unit test ini menggunakan mocking untuk isolate dependencies
 * - Untuk testing yang lebih comprehensive, gunakan Feature Test
 * - AuthController lebih cocok untuk Feature Test karena heavily depend pada framework
 */
class AuthControllerUnitTest extends TestCase
{
    use RefreshDatabase;

    protected AuthController $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new AuthController();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * Test redirectBasedOnRole untuk teacher
     * 
     * Ini adalah unit test murni yang test logic redirect
     * tanpa HTTP request
     */
    public function test_redirect_based_on_role_returns_teacher_dashboard_for_teacher(): void
    {
        // Arrange
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'email' => 'teacher@test.com'
        ]);

        // Act - Kita gunakan reflection untuk akses private method
        $reflection = new \ReflectionClass($this->controller);
        $method = $reflection->getMethod('redirectBasedOnRole');
        $method->setAccessible(true);
        
        $result = $method->invoke($this->controller, $teacher);

        // Assert
        $this->assertInstanceOf(RedirectResponse::class, $result);
        $this->assertEquals(route('teacher.dashboard'), $result->getTargetUrl());
    }

    /**
     * Test redirectBasedOnRole untuk student
     */
    public function test_redirect_based_on_role_returns_student_dashboard_for_student(): void
    {
        // Arrange
        $student = User::factory()->create([
            'role' => 'student',
            'email' => 'student@test.com'
        ]);

        // Act
        $reflection = new \ReflectionClass($this->controller);
        $method = $reflection->getMethod('redirectBasedOnRole');
        $method->setAccessible(true);
        
        $result = $method->invoke($this->controller, $student);

        // Assert
        $this->assertInstanceOf(RedirectResponse::class, $result);
        $this->assertEquals(route('student.dashboard'), $result->getTargetUrl());
    }

    /**
     * Test redirectBasedOnRole untuk role yang tidak valid
     */
    public function test_redirect_based_on_role_returns_landing_with_error_for_invalid_role(): void
    {
        // Arrange
        $user = User::factory()->create([
            'role' => 'invalid_role',
            'email' => 'invalid@test.com'
        ]);

        // Act
        $reflection = new \ReflectionClass($this->controller);
        $method = $reflection->getMethod('redirectBasedOnRole');
        $method->setAccessible(true);
        
        $result = $method->invoke($this->controller, $user);

        // Assert
        $this->assertInstanceOf(RedirectResponse::class, $result);
        $this->assertEquals(route('landing'), $result->getTargetUrl());
    }

    /**
     * Test showLanding dengan mock Auth
     * 
     * Unit test dengan mocking Auth facade
     */
    public function test_show_landing_returns_view_for_guest(): void
    {
        // Arrange - Mock Auth facade
        Auth::shouldReceive('check')
            ->once()
            ->andReturn(false);

        // Act
        $result = $this->controller->showLanding();

        // Assert
        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('landing', $result->name());
    }

    /**
     * Test showLogin returns view untuk guest
     */
    public function test_show_login_returns_view_for_guest(): void
    {
        // Arrange
        Auth::shouldReceive('check')
            ->once()
            ->andReturn(false);

        // Act
        $result = $this->controller->showLogin();

        // Assert
        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('auth.login', $result->name());
    }

    /**
     * Test logout dengan real request (hybrid approach)
     * 
     * Note: Ini lebih ke arah feature test, tapi masih di unit test folder
     * untuk demonstrasi purposes
     */
    public function test_logout_redirects_to_landing(): void
    {
        // Arrange
        $request = Request::create('/logout', 'POST');
        $request->setLaravelSession($this->app['session.store']);
        
        // Create authenticated user
        $user = User::factory()->create();
        $this->actingAs($user);

        // Act
        $result = $this->controller->logout($request);

        // Assert
        $this->assertInstanceOf(RedirectResponse::class, $result);
        $this->assertEquals(route('landing'), $result->getTargetUrl());
        $this->assertGuest();
    }

    /**
     * Test login method exists
     */
    public function test_login_method_exists(): void
    {
        // Arrange & Act
        $hasMethod = method_exists($this->controller, 'login');

        // Assert
        $this->assertTrue($hasMethod, 'AuthController harus memiliki method login');
    }

    /**
     * Test semua public methods ada
     */
    public function test_controller_has_all_required_public_methods(): void
    {
        // Arrange
        $requiredMethods = [
            'showLanding',
            'showLogin',
            'login',
            'logout'
        ];

        // Act & Assert
        foreach ($requiredMethods as $method) {
            $this->assertTrue(
                method_exists($this->controller, $method),
                "AuthController harus memiliki method {$method}"
            );
        }
    }

    /**
     * Test private method redirectBasedOnRole exists
     */
    public function test_controller_has_redirect_based_on_role_method(): void
    {
        // Arrange & Act
        $reflection = new \ReflectionClass($this->controller);
        $hasMethod = $reflection->hasMethod('redirectBasedOnRole');

        // Assert
        $this->assertTrue($hasMethod, 'AuthController harus memiliki method redirectBasedOnRole');
    }

    /**
     * Test controller instantiation
     */
    public function test_controller_can_be_instantiated(): void
    {
        // Assert
        $this->assertInstanceOf(AuthController::class, $this->controller);
    }
}
