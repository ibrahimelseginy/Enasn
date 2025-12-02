<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payroll extends Model
{
    protected $fillable = ['user_id','month','amount','currency','paid_at'];
    protected $casts = ['paid_at' => 'date'];
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}
