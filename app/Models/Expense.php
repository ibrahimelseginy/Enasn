<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    protected $fillable = ['type','amount','currency','description','project_id','campaign_id','beneficiary_id','created_by','paid_at','attachment_path'];

    protected $casts = ['paid_at' => 'date'];

    public function project(): BelongsTo { return $this->belongsTo(Project::class); }
    public function campaign(): BelongsTo { return $this->belongsTo(Campaign::class); }
    public function beneficiary(): BelongsTo { return $this->belongsTo(Beneficiary::class); }
    public function creator(): BelongsTo { return $this->belongsTo(User::class, 'created_by'); }
}
