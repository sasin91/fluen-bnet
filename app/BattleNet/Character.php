<?php

namespace App\BattleNet;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    /**
     * Array of in-game races
     *
     * @var array
     */
    protected $races = [
        'Unknown',
        'Human',
        'Orc',
        'Dwarf',
        'Night Elf',
        'Undead',
        'Tauren',
        'Gnome',
        'Troll',
        'Goblin',
        'Blood Elf',
        'Draenei',
        'Fel Orc',
        'Naga',
        'Broken',
        'Skeleton',
        'Vrykul',
        'Tuskarr',
        'Forest Troll',
        'Taunka',
        'Northrend Skeleton',
        'Ice Troll',
        'Worgen'
    ];

    /**
     * Array of in-game classes
     *
     * @var array
     */
    protected $classes = [
        'Unknown',
        'Warrior',
        'Paladin',
        'Hunter',
        'Rogue',
        'Priest',
        'Death Knight',
        'Shaman',
        'Mage',
        'Warlock',
        'Monk',
        'Druid',
        'Demon Hunter'
    ];
    /**
     * Array of in-game genders.
     *
     * @var array
     */
    protected $genders = [
        'male',
        'female',
    ];

    /**
     * @inheritdoc
     */
    public $timestamps = False;

    /**
     * @inheritdoc
     */
    public $dates = [
        'lastModified'
    ];

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'name',
        'realm',
        'battlegroup',
        'class',
        'race',
        'gender',
        'level',
        'spec',
        'achievementPoints',
        'thumbnail',
        'lastModified'
    ];

    /**
     * @inheritdoc
     */
    protected $casts = [
        'class'             =>  'integer',
        'race'              =>  'integer',
        'gender'            =>  'integer',
        'level'             =>  'integer',
        'spec'              =>  'object',
        'achievementPoints' =>  'integer',
        'lastModified'      =>  'timestamp'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function spec()
    {
        return $this->belongsToMany(CharacterSpec::class, 'bnet_character_pivot_specs');
    }

    public function setSpecAttribute(CharacterSpec $characterSpec)
    {
        $this->spec()->save($characterSpec);
    }

    /**
     * Eloquent Attribute Accessor
     *
     *
     * @param int $race
     * @return string
     */
    public function getRaceAttribute(int $race) : string
    {
        return array_get($this->races, $race, 'Unknown');
    }

    /**
     * Eloquent Attribute mutator.
     *
     *
     * @param string $race
     */
    public function setRaceAttribute(string $race)
    {
        if (! is_numeric($race))
        {
            $race = array_search($race, $this->races) ?: 0;
        }

        $this->attributes['race'] = $race;
    }

    public function getClassAttribute(int $class) : string
    {
        return array_get($this->classes, $class, 'Unknown');
    }

    public function setClassAttribute($class)
    {
        if (! is_numeric($class))
        {
            $class = array_search($class, $this->classes) ?: 0;
        }

        $this->attributes['class'] = $class;
    }

    public function getGenderAttribute(int $gender) : string
    {
        return array_get($this->genders, $gender, 'Unknown');
    }

    public function setGenderAttribute($gender)
    {
        if (! is_numeric($gender))
        {
            $gender = array_search($gender, $this->genders) ?: 'Unknown';
        }

        $this->attributes['gender'] = $gender;
    }

    public function setThumbnailAttribute(string $uri)
    {
        $this->attributes['thumbnail'] = "http://render-api-eu.worldofwarcraft.com/static-render/eu/$uri";
    }
}
