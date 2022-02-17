<?php

namespace App\Models;

use App\Traits\AddUuid;
use App\Traits\Sluggify;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, AddUuid, Sluggify;

}
