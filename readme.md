# Chance

A Laravel PHP library for reloading cached data based on chance instead of time.

## Install

Normal install via Composer.

## Usage

```php
$value = Travis\Chance::get('foobar', 2, function() {

    // complicated stuff w/ 2% probability of being triggered, 5 min cooldown

    // return
    return $value;

}, 5);

$bat = 'myvalue';
$value = Travis\Chance::get('foobar', 20, function() use($bat) {

    // complicated stuff w/ 20% probability of being triggered that uses $bat, w/ no cooldown

    // return
    return $value;

});
```

Call the ``get()`` method and include a variable name, a percentage probability of reload, and a closure for the calculation of the desired value.  The optional ``cooldown`` param means no dice rolls attempted for that minimum amount of time.