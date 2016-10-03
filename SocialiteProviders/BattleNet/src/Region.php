<?php

namespace SocialiteProviders\BattleNet;

/**
 * Class Region
 * @package SocialiteProviders\BattleNet
 *
 * @credits (c) Jonas Stendahl <jonas@stendahl.me>
 * @origin https://github.com/jyggen/bnet/blob/master/src/Region.php
 */
class Region
{
    /**
     * @var string
     */
    const CHINA = 'cn';
    /**
     * @var string
     */
    const EUROPE = 'eu';
    /**
     * @var string
     */
    const KOREA = 'kr';
    /**
     * @var string
     */
    const TAIWAN = 'tw';
    /**
     * @var string
     */
    const US = 'us';
    /**
     * @var array
     */
    protected static $regions = [
        self::CHINA => [
            'locales' => ['zh_CN'],
            'hosts' => [
                'api' => 'https://www.battlenet.com.cn/%s/',
                'oauth' => 'https://cn.battle.net/oauth/%s',
            ],
        ],
        self::EUROPE => [
            'locales' => ['en_GB', 'es_ES', 'fr_FR', 'ru_RU', 'de_DE', 'pt_PT', 'it_IT'],
            'hosts' => [
                'api' => 'https://eu.api.battle.net/%s/',
                'oauth' => 'https://eu.battle.net/oauth/%s',
            ],
        ],
        self::KOREA => [
            'locales' => ['ko_KR'],
            'hosts' => [
                'api' => 'https://kr.api.battle.net/%s/',
                'oauth' => 'https://kr.battle.net/oauth/%s',
            ],
        ],
        self::TAIWAN => [
            'locales' => ['zh_TW'],
            'hosts' => [
                'api' => 'https://tw.api.battle.net/%s/',
                'oauth' => 'https://tw.battle.net/oauth/%s',
            ],
        ],
        self::US => [
            'locales' => ['en_US', 'es_MX', 'pt_BR'],
            'hosts' => [
                'api' => 'https://us.api.battle.net/%s/',
                'oauth' => 'https://us.battle.net/oauth/%s',
            ],
        ],
    ];
    /**
     * @var string
     */
    protected $host;
    /**
     * @var string
     */
    protected $locale;
    /**
     * @var array
     */
    protected $region;
    /**
     * @return array
     */
    public static function all()
    {
        return static::$regions;
    }
    /**
     * @param string $region
     * @param string $locale
     */
    public function __construct($region, $locale = null)
    {
        if (isset(static::$regions[$region]) === false) {
            throw new \InvalidArgumentException($region.' is not a valid region');
        }
        $this->region = static::$regions[$region];
        if ($locale !== null && in_array($locale, $this->region['locales'], true) === false) {
            throw new \InvalidArgumentException($locale.' is not a valid locale');
        }
        $this->locale = ($locale === null) ? $this->region['locales'][0] : $locale;
    }

    /**
     * @param string $uri
     *
     * @return string
     */
    public function apiUrl(string $uri)
    {
        return sprintf($this->region['hosts']['api'], $uri);
    }

    /**
     * @param string $uri
     *
     * @return string
     */
    public function oAuthUrl(string $uri)
    {
        return sprintf($this->region['hosts']['oauth'], $uri);
    }
    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }
}