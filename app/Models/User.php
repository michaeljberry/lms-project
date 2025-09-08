<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function hasRole(string $role): bool
    {
        return $this->roles()->where('name', $role)->exists();
    }

    public function coursePermissions()
    {
        return $this->belongsToMany(Permission::class, 'course_permission_user')
            ->withPivot('course_id', 'allow')
            ->withTimestamps();
    }

    protected function resolveRoles()
    {
        $roles = $this->roles()->with('parents')->get();
        $resolved = collect();
        $queue = $roles->all();

        while ($queue) {
            $role = array_shift($queue);
            if (!$resolved->contains('id', $role->id)) {
                $resolved->push($role);
                foreach ($role->parents as $parent) {
                    $queue[] = $parent;
                }
            }
        }

        return $resolved;
    }

    public function hasPermission(string $permission, ?Course $course = null): bool
    {
        return $this->checkPermission($permission, $course);
    }

    protected function checkPermission(string $permission, ?Course $course = null): bool
    {
        $permissionModel = Permission::where('name', $permission)->first();
        if (!$permissionModel) {
            return false;
        }

        if ($course) {
            $override = $this->coursePermissions()
                ->wherePivot('course_id', $course->id)
                ->where('permissions.id', $permissionModel->id)
                ->first();

            if ($override) {
                return (bool) $override->pivot->allow;
            }
        }

        $roles = $this->resolveRoles();
        $allowed = false;

        foreach ($roles as $role) {
            $perm = $role->permissions()->where('permissions.id', $permissionModel->id)->first();
            if ($perm) {
                if (!$perm->pivot->allow) {
                    return false;
                }
                $allowed = true;
            }
        }

        return $allowed;
    }
}
