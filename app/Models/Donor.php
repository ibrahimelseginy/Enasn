<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Donor extends Model
{
    protected $fillable = [
        'name','type','phone','email','address','classification','recurring_cycle','active','sponsorship_type','sponsored_beneficiary_id','sponsorship_project_id','sponsorship_monthly_amount'
    ];

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }
}
