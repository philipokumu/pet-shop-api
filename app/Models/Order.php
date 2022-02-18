<?php

namespace App\Models;

use App\Traits\AddUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, AddUuid;

    protected $guarded = [];

}
