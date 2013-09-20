<?php

/**
 * A library to reload cached data based on chance instead of time.
 *
 * @package    Chance
 * @author     Scott Travis <scott.w.travis@gmail.com>
 * @link       http://github.com/swt83/laravel-chance
 * @license    MIT License
 */

class Chance
{
    public static function get($variable, $chance, $function, $cooldown = null)
    {
        // load existing
        $cached = Cache::get($variable);

        // if not existing, calculate...
        if (!$cached) {

            // calculate
            $value = $function();

            // save variable
            Cache::forever($variable, $value);

            // save timer
            if ($cooldown) Cache::put($variable.'_timer', 1, $cooldown);

            // return
            return $value;

        }

        // determine if rolling dice...
        $rolldice = true;
        if ($cooldown) {
            $rolldice = Cache::get($variable.'_timer') ? false : true;
        }

        // if rolling dice...
        if ($rolldice) {

            // build pool...
            $pool = array();
            for ($i=1; $i<=$chance; $i++) {
                $pool[] = $i;
            }

            // roll dice
            $roll = rand(1, 100);

            // if roll found in pool...
            if (in_array($roll, $pool)) {

                // calculate
                $value = $function();

                // save variable
                Cache::forever($variable, $value);

                // save timer
                if ($cooldown) Cache::put($variable.'_timer', 1, $cooldown);

                // return
                return $value;

            }

        }

        // return
        return $cached;
    }
}