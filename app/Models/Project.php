<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    protected $fillable = ['name','fixed','status','description','manager_user_id','deputy_user_id','manager_photo_url','deputy_photo_url'];

    protected $casts = ['fixed' => 'boolean'];

    public function donations(): HasMany { return $this->hasMany(Donation::class); }
    public function beneficiaries(): HasMany { return $this->hasMany(Beneficiary::class); }
    public function manager(): BelongsTo { return $this->belongsTo(User::class, 'manager_user_id'); }
    public function deputy(): BelongsTo { return $this->belongsTo(User::class, 'deputy_user_id'); }
    public function volunteers(): BelongsToMany { return $this->belongsToMany(User::class, 'project_volunteers')->withPivot(['role','started_at','campaign_id'])->withTimestamps(); }
}
