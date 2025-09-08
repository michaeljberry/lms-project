<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class)->withPivot('allow')->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function parents()
    {
        return $this->belongsToMany(Role::class, 'role_hierarchy', 'child_id', 'parent_id');
    }

    public function children()
    {
        return $this->belongsToMany(Role::class, 'role_hierarchy', 'parent_id', 'child_id');
    }
}
