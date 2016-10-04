<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activation extends Model
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        static::creating(function (Activation $model) {
            $model->freshToken();
        });

        parent::boot();
    }

    /**
     * @param Model|Activatable $model
     * @return static
     */
    public static function generate(Model $model)
    {
        return static::create([
            'activatable_type'  =>  get_class($model),
            'activatable_id'    =>  $model->getKey()
        ]);
    }

    /**
     * Generates a fresh token on the Model.
     */
    protected function freshToken()
    {
        $this->attributes['token'] = str_random();
    }

    /**
     * The activatable relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function activatable()
    {
        return $this->morphTo();
    }
}
