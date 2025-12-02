<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryTransaction extends Model
{
    protected $fillable = [
        'item_id','warehouse_id','type','quantity','source_donation_id','beneficiary_id','project_id','campaign_id','reference'
    ];

    public function item(): BelongsTo { return $this->belongsTo(Item::class); }
    public function warehouse(): BelongsTo { return $this->belongsTo(Warehouse::class); }
    public function sourceDonation(): BelongsTo { return $this->belongsTo(Donation::class, 'source_donation_id'); }
    public function beneficiary(): BelongsTo { return $this->belongsTo(Beneficiary::class); }
    public function project(): BelongsTo { return $this->belongsTo(Project::class); }
    public function campaign(): BelongsTo { return $this->belongsTo(Campaign::class); }
}
