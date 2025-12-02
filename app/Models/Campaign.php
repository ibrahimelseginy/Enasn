<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campaign extends Model
{
    protected $fillable = ['name','season_year','start_date','end_date','status'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    public function donations(): HasMany { return $this->hasMany(Donation::class); }
    public function beneficiaries(): HasMany { return $this->hasMany(Beneficiary::class); }
}
