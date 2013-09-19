# Chance

A library for reloading cached data based on chance instead of time.

## Install

Normal bundle install.

## Usage

```php
$value = Chance::get('foobar', 2, function() {

    // complicated stuff w/ 2% probability of being triggered

    // return
    return $value;

});

$bat = 'myvalue';
$value = Chance::get('foobar', 20, function() use($bat) {

    // complicated stuff w/ 20% probability of being triggered that uses $bat

    // return
    return $value;

});
```

Call the get() method and include a variable name, a percentage probability of reload, and a closure for the calculation of the desired value.