<?php

namespace App;


use App\Scopes\ActivatingScope;

/**
 * Class Activation
 * @package App
 *
 * Makes a model require activation.
 *
 * @method static \Illuminate\Database\Eloquent\Builder withDeactivated Macro
 * @method static \Illuminate\Database\Eloquent\Builder onlyDeactivated Macro
 *
 * @property Activation activation
 */
trait Activatable
{
    /**
     * Boot the activating trait for a model.
     *
     * @return void
     */
    public static function bootActivation()
    {
        static::addGlobalScope(new ActivatingScope);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function activation()
    {
        return $this->morphOne(Activation::class, 'activatable');
    }

    /**
     * Get the name of the "activated" column.
     *
     * @return string
     */
    public function getActivatedColumn()
    {
        return defined('static::ACTIVATED') ? static::ACTIVATED : 'activated';
    }

    /**
     * Get the fully qualified "activated" column.
     *
     * @return string
     */
    public function getQualifiedActivatedColumn()
    {
        return $this->getTable().'.'.$this->getActivatedColumn();
    }

    /**
     * Activate a model instance.
     *
     *
     * @param string $token
     * @return bool|null
     */
    public function activate(string $token)
    {
        // If the activating event does not return false, we will proceed with this
        // activation. Otherwise, we bail out.
        if ($this->fireModelEvent('activating') === false) {
            return false;
        }

        // If no activation was found
        // or the activation token is invalid then we bail out.
        if (is_null($results = $this->activation()->getResults()) || $results->token !== $token)
        {
            return false;
        }

        // Once we have saved the model, we will fire the "activated" event so
        // the developer listen for it and execute whatever they may want right after.
        $this->{$this->getActivatedColumn()} = true;

        $saved = $this->save();

        $this->fireModelEvent('activated', false);

        return $saved;
    }

    /**
     * Deactivate a model instance.
     *
     * @return bool|null
     */
    public function deactivate()
    {
        // If the deactivating event does not return false, we will proceed with this
        // activation. Otherwise, we bail out.
        if ($this->fireModelEvent('deactivating') === false) {
            return false;
        }

        // Once we have saved the model, we will fire the "deactivated" event so
        // the developer listen for it and execute whatever they may want right after.
        $this->{$this->getActivatedColumn()} = false;

        $result = $this->save();

        $this->fireModelEvent('deactivated', false);

        return $result;
    }

    /**
     * Determine if the model instance is deactivated.
     *
     * @return bool
     */
    public function isDeactivated()
    {
        return ($this->{$this->getActivatedColumn()} === false);
    }

    /**
     * Determine if the model instance is activated.
     *
     * @return bool
     */
    public function isActivated()
    {
        return ! $this->isDeactivated();
    }

    /**
     * Register a activating model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function activating($callback)
    {
        static::registerModelEvent('activating', $callback);
    }

    /**
     * Register a activated model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function activated($callback)
    {
        static::registerModelEvent('activated', $callback);
    }

    /**
     * Register a deactivating model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function deactivating($callback)
    {
        static::registerModelEvent('deactivating', $callback);
    }

    /**
     * Register a deactivated model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function deactivated($callback)
    {
        static::registerModelEvent('deactivated', $callback);
    }
}