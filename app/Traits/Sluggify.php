<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Sluggify
{
    public static function bootSluggify()
    {
        static::created(function ($model) {

            $model->slug = Str::slug($model->title . '-' . $model->id);
            $model->save();
        });

        static::saving(function ($model) {
            if ($model->isDirty(['title'])) {
                $model->slug = Str::slug($model->title . '-' . $model->id);
            }
        });
    }

   /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    // public function getIncrementing()
    // {
    //     return false;
    // }

   /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    // public function getKeyType()
    // {
    //     return 'string';
    // }
}