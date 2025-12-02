<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    protected $fillable = ['sku','name','unit','estimated_value'];

    public function transactions(): HasMany { return $this->hasMany(InventoryTransaction::class); }
}
