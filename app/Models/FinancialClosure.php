<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialClosure extends Model
{
    protected $fillable = ['date','branch','closed_by','approved_by','approved'];
    protected $casts = ['date' => 'date','approved' => 'boolean'];
}
