<?php

namespace App;
use App\Scopes\ConfirmingScope;


/**
 * Class Confirmation
 * @package App
 *
 * Makes a model require activation.
 *
 * @method static \Illuminate\Database\Eloquent\Builder withUnconfirmed Macro
 * @method static \Illuminate\Database\Eloquent\Builder onlyUnconfirmed Macro
 *
 * @property Token confirmation
 */
trait Confirmable
{
    /**
     * Boot the activating trait for a model.
     *
     * @return void
     */
    public static function bootConfirmable()
    {
        static::addGlobalScope(new ConfirmingScope);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function confirmation()
    {
        return $this->morphOne(Token::class, 'tokenable');
    }

    /**
     * Get the name of the "confirmable" column.
     *
     * @return string
     */
    public function getConfirmableColumn()
    {
        return defined('static::CONFIRMABLE') ? static::CONFIRMABLE : 'email';
    }

    /**
     * Get the fully qualified "confirmable" column.
     *
     * @return string
     */
    public function getQualifiedConfirmableColumn()
    {
        return $this->getTable().'.'.$this->getConfirmableColumn();
    }

    /**
     * Activate a model instance.
     *
     *
     * @param string $token
     * @return bool|null
     */
    public function confirm(string $token)
    {
        // If no token was found
        // or the token is invalid then we bail out.
        if (is_null($results = $this->confirmation()->getResults()) || $results->token !== $token)
        {
            return false;
        }

        $this->{$this->getConfirmableColumn()} = true;

        return $this->save();
    }

    /**
     * Deactivate a model instance.
     *
     * @return bool|null
     */
    public function unConfirm()
    {
        $this->{$this->getConfirmableColumn()} = false;

        $result = $this->save();

        return $result;
    }

    /**
     * Determine if the model instance is unconfirmed.
     *
     * @return bool
     */
    public function isUnconfirmed()
    {
        return ($this->{$this->getActivatedColumn()} === false);
    }

    /**
     * Determine if the model instance is confirmed.
     *
     * @return bool
     */
    public function isConfirmed()
    {
        return ! $this->isUnconfirmed();
    }

    /**
     * Register a confirming model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function confirming($callback)
    {
        static::registerModelEvent('confirming', $callback);
    }

    /**
     * Register a confirmed model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function confirmed($callback)
    {
        static::registerModelEvent('confirmed', $callback);
    }
}