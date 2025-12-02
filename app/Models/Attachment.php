<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Attachment extends Model
{
    protected $fillable = ['entity_type','entity_id','path','mime'];

    public function attachable(): MorphTo
    {
        return $this->morphTo(null, 'entity_type', 'entity_id');
    }
}
