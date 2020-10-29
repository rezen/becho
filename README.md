# becho
[![Latest Stable Version](https://poser.pugx.org/rezen/becho/v)](//packagist.org/packages/rezen/becho)

Don't use `echo` ... use `becho`!


## Install

`composer install rezen/becho` 

## Example
In your app, wherever you init and configure things, add a wrapper  
```php
<?php

// Basic example
becho("Some yellow text", ['color' => BECHO_YELLOW]);


// Or if you are not using a templating engine, you can echo safely
?>
<input type="text" value="<?php becho($value, BECHO_ESC_ATTR); ?>" />
```

