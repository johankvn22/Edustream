<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Create a teacher user.
     */
    protected function createTeacher(array $attributes = [])
    {
        return \App\Models\User::factory()->teacher()->create($attributes);
    }

    /**
     * Create a student user.
     */
    protected function createStudent(array $attributes = [])
    {
        return \App\Models\User::factory()->student()->create($attributes);
    }

    /**
     * Act as a teacher user.
     */
    protected function actingAsTeacher(array $attributes = [])
    {
        return $this->actingAs($this->createTeacher($attributes));
    }

    /**
     * Act as a student user.
     */
    protected function actingAsStudent(array $attributes = [])
    {
        return $this->actingAs($this->createStudent($attributes));
    }
}
