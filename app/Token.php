<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Token
 * @package App
 *
 * @property string token
 */
class Token extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        static::creating(function (Token $model) {
            $model->freshToken();
        });

        parent::boot();
    }

    /**
     * Generates a fresh token on the Model.
     */
    protected function freshToken()
    {
        $this->attributes['token'] = str_random();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function tokenable()
    {
        return $this->morphTo();
    }
}
