<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $fillable = ['item', 'unit_amount', 'ratio_produced', 'price', 'description', 'status'];
}
