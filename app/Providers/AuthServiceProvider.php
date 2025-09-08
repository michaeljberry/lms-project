<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\User;
use App\Models\Course;
use App\Models\Profile;
use App\Models\Permission;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use App\Policies\ProfilePolicy;
use App\Policies\PermissionPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class,
        Profile::class => ProfilePolicy::class,
        User::class => UserPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
        Gate::define('view_course', function (User $user, ?Course $course = null) {
            return $user->hasPermission('view_course', $course);
        });

        // Optionally: generic pass-through for any Permission name
        Gate::before(function (User $user, string $ability, ?array $arguments = []) {
            // If this ability matches a Permission record, use RBAC
            if (\App\Models\Permission::where('name', $ability)->exists()) {
                $course = $arguments[0] ?? null; // pass Course if provided
                return $user->hasPermission($ability, $course);
            }
            return null; // fall back to policies
        });
    }
}
