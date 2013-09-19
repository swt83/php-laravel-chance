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
    public static function get($variable, $chance, $function)
    {
        // load existing
        $cached = Cache::get($variable);

        // if not existing, bail...
        if (!$cached) {

            // calculate
            $value = $function();

            // save
            Cache::forever($variable, $value);

            // return
            return $value;

        }

        // build pool...
        $pool = array();
        for ($i=0; $i<=$chance; $i++) {
            $pool[] = $i;
        }

        // roll dice
        $roll = rand(1, 100);

        // if roll found in pool...
        if (in_array($roll, $pool)) {

            // calculate
            $value = $function();

            // save
            Cache::forever($variable, $value);

            // return
            return $value;

        }

        // return
        return $cached;
    }
}