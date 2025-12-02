<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestHouse extends Model
{
    protected $fillable = ['name','location','phone','capacity','status','description'];
}

