<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RbacTest extends TestCase
{
    use RefreshDatabase;

    public function test_role_hierarchy_and_course_override(): void
    {
        $permission = Permission::create(['name' => 'view_course']);

        $student = Role::create(['name' => 'student']);
        $instructor = Role::create(['name' => 'instructor']);
        $admin = Role::create(['name' => 'admin']);

        // hierarchy admin -> instructor -> student
        $instructor->parents()->syncWithoutDetaching($student);
        $admin->parents()->syncWithoutDetaching($instructor);

        // student allowed, instructor explicit deny
        $student->permissions()->attach($permission, ['allow' => true]);
        $instructor->permissions()->attach($permission, ['allow' => false]);

        $user = User::factory()->create();
        $user->roles()->attach($admin);

        $this->assertFalse($user->can('view_course'));

        $course = Course::create(['title' => 'Physics']);
        $user->coursePermissions()->attach($permission, [
            'course_id' => $course->id,
            'allow' => true,
        ]);

        $this->assertTrue($user->can('view_course', $course));
    }
}
