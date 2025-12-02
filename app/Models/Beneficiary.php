<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Beneficiary extends Model
{
    protected $fillable = [
        'full_name','national_id','phone','address','assistance_type','status','project_id','campaign_id'
    ];

    public function project(): BelongsTo { return $this->belongsTo(Project::class); }
    public function campaign(): BelongsTo { return $this->belongsTo(Campaign::class); }
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable', 'entity_type', 'entity_id');
    }
}
