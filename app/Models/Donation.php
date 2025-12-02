<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donation extends Model
{
    protected $fillable = [
        'donor_id','type','cash_channel','amount','currency','receipt_number','estimated_value','project_id','campaign_id','warehouse_id','delegate_id','route_id','allocation_note','received_at'
    ];

    protected $casts = [
        'received_at' => 'datetime'
    ];

    public function donor(): BelongsTo { return $this->belongsTo(Donor::class); }
    public function project(): BelongsTo { return $this->belongsTo(Project::class); }
    public function campaign(): BelongsTo { return $this->belongsTo(Campaign::class); }
    public function warehouse(): BelongsTo { return $this->belongsTo(Warehouse::class); }
    public function delegate(): BelongsTo { return $this->belongsTo(Delegate::class); }
    public function route(): BelongsTo { return $this->belongsTo(TravelRoute::class, 'route_id'); }
}
