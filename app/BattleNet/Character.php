<?php

namespace App\BattleNet;

use App\User;
use Illuminate\Database\Eloquent\Model;
use SocialiteProviders\BattleNet\Region;

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
        'class'             =>  'string',
        'race'              =>  'string',
        'gender'            =>  'string',
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
        return $this->belongsToMany(CharacterSpec::class);
    }

    public function setSpecAttribute(CharacterSpec $characterSpec)
    {
        $this->spec()->save($characterSpec);
    }

    /**
     * Eloquent Attribute mutator.
     *
     *
     * @param string|int $race
     */
    public function setRaceAttribute($race)
    {
        if (is_numeric($race))
        {
            $race = $this->valueOrFirstOf($this->races, $race);
        }

        $this->attributes['race'] = $race;
    }

    public function setClassAttribute($class)
    {
        if (is_numeric($class))
        {
            $class = $this->valueOrFirstOf($this->classes, $class);
        }

        $this->attributes['class'] = $class;
    }

    public function setGenderAttribute($gender)
    {
        if (is_numeric($gender))
        {
            $gender = $this->valueOrFirstOf($this->genders, $gender);
        }

        $this->attributes['gender'] = $gender;
    }

    /**
     * Appends the missing part of the given uri.
     *
     * @param string $uri
     */
    public function setThumbnailAttribute(string $uri)
    {
        $this->attributes['thumbnail'] = filter_var($uri, FILTER_VALIDATE_URL) ?: $this->region()->avatarUrl($uri);
    }

    /**
     * @return Region
     */
    protected function region()
    {
        return app('BattleNet.Region');
    }

    /**
     * Returns the value corresponding to given key
     * or first of given array.
     *
     *
     * @param array $array
     * @param string|int $key
     * @return string
     */
    protected function valueOrFirstOf(array $array, $key) : string
    {
        return array_get($array, $key, reset($array));
    }
}
