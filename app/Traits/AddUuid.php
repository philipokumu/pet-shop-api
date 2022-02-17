<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait AddUuid
{
    public static function bootAddUuid()
    {
        static::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }

   /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }

   /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }
}