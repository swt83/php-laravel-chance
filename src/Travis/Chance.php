<?php

namespace Travis;

class Chance {

    /**
     * Get a variable as based on cache and change.
     *
     * @param   string      $variable
     * @param   int         $chance
     * @param   function    $function
     * @param   int         $cooldown
     * @return  mixed
     */
    public static function get($variable, $chance, $function, $cooldown = null)
    {
        // load existing
        $cached = \Cache::get($variable);

        // if not existing, calculate...
        if (!$cached)
        {
            // calculate
            $value = $function();

            // save variable
            \Cache::forever($variable, $value);

            // save timer
            if ($cooldown) \Cache::put($variable.'_timer', 1, $cooldown);

            // return
            return $value;
        }

        // determine if rolling dice...
        $rolldice = true;
        if ($cooldown)
        {
            $rolldice = \Cache::get($variable.'_timer') ? false : true;
        }

        // if rolling dice...
        if ($rolldice)
        {

            // build pool...
            $pool = array();
            for ($i=1; $i<=$chance; $i++)
            {
                $pool[] = $i;
            }

            // roll dice
            $roll = rand(1, 100);

            // if roll found in pool...
            if (in_array($roll, $pool))
            {
                // calculate
                $value = $function();

                // save variable
                \Cache::forever($variable, $value);

                // save timer
                if ($cooldown) \Cache::put($variable.'_timer', 1, $cooldown);

                // return
                return $value;
            }

        }

        // return
        return $cached;
    }

}