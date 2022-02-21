<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait AddUuid
{
    public static function bootAddUuid()
    {
        static::creating(function ($model) {
            if (!isset($model->uuid)) {
                $model->uuid = Str::uuid()->toString();
            }
        });
    }
}