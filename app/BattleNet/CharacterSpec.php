<?php

namespace App\BattleNet;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CharacterSpec
 * @package App\BattleNet
 *
 * @method static CharacterSpec firstOrCreate(array $attributes = []) @see Illuminate/Database/Eloquent/Builder
 */
class CharacterSpec extends Model
{
    protected $table = 'character_specs';

    protected $fillable = [
        'name',
        'role',
        'backgroundImage',
        'icon',
        'description',
        'order'
    ];

    protected $casts = [
        'order' =>  'integer'
    ];

    public $timestamps = false;

    public function character()
    {
        return $this->belongsToMany(Character::class, 'character_spec_character');
    }

    public function setBackgroundImageAttribute(string $uri)
    {
        $this->attributes['backgroundImage'] = "http://render-api-eu.worldofwarcraft.com/static-render/eu/$uri";
    }

    public function setIconAttribute(string $uri)
    {
        $this->attributes['icon'] = "http://render-api-eu.worldofwarcraft.com/static-render/eu/$uri";
    }
}
