# becho
[![Latest Stable Version](https://poser.pugx.org/rezen/becho/v)](//packagist.org/packages/rezen/becho)

Don't use `echo` ... use `becho`!


## Install

`composer install rezen/becho` 

## Example
In your app, wherever you init and configure things, add a wrapper  
```php
// Basic example
becho("Some colored text", ['color' => BECHO_YELLOW]);
```

