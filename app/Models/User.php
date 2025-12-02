<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    protected $fillable = ['name','email','password','phone','is_employee','is_volunteer','active'];

    protected $hidden = ['password'];

    protected $casts = ['is_employee' => 'boolean','is_volunteer' => 'boolean','active' => 'boolean'];

    public function roles(): BelongsToMany { return $this->belongsToMany(Role::class); }
    public function assignedTasks(): HasMany { return $this->hasMany(Task::class, 'assigned_to'); }
    public function createdTasks(): HasMany { return $this->hasMany(Task::class, 'assigned_by'); }
    public function projects(): BelongsToMany { return $this->belongsToMany(Project::class, 'project_volunteers')->withPivot(['role','started_at','campaign_id'])->withTimestamps(); }
}
