<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class plans extends Model
{
    use HasFactory;
    protected $fillable = [
        'plan_id', 'plan_name', 'billing_method', 'interval_count', 'price', 'currency'
    ];
}
