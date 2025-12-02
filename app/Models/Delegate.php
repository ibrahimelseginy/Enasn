<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Delegate extends Model
{
    protected $fillable = ['name','phone','email','route_id','active'];

    protected $casts = ['active' => 'boolean'];

    public function route(): BelongsTo { return $this->belongsTo(TravelRoute::class, 'route_id'); }
    public function donations(): HasMany { return $this->hasMany(Donation::class); }
}
