# RedBean queries logger for Tracy
With this you will be able to see your logged queries with RedBean, this little package also provides a PSR-7 middleware if you're using frameworks like Slim, Silex, or whatever.

## Result
![RedBeanPHP queries logger for Tracy](https://i.snag.gy/T5Ok1R.jpg "RedBeanPHP queries logger for Tracy")

## Installation and configuration
`composer require filisko/tracy-redbean`

To make this work you must enable RedBean's debug mode to log your queries. You can simply use RedBean's Facade debug() method.

## How to use

#### Basic example
To use this logger with any application, you could basically do something like that:

```php
R::setup('mysql:host=hostname;dbname=db', 'username', 'password');
/*
Possible log modes:
-------------------
0 Log and write to STDOUT classic style (default)
1 Log only, class style
2 Log and write to STDOUT fancy style
3 Log only, fancy style (it works nicely with this one)
*/
R::debug(true, 3);

// ... your queries here ...

// Get RedBean's Logger
$logger = R::getLogger();

// Create new instance of the panel
$panel = new \Filisko\Tracy\RedBeanBarPanel($logger);

// Boot the panel (collect and show the panel)
\Filisko\Tracy\RedBeanBarPanel::boot($panel);
```

#### Middleware example
If you are using some framework that works with PSR-7, you could use the logger like that:

```php
// Get RedBean's Logger
$logger = R::getLogger();

// Create new instance of the panel
$panel = new \Filisko\Tracy\RedBeanBarPanel($logger);

// Add to middleware
$app->add(new \Filisko\Tracy\RedBeanBarPanelMiddleware($panel));
```

### Extras
* If you realized that RedBean puts at the end of your SQL queries something like '--keep-cache' for internal caching purposes and you want to hide this part from the logger, you could simply use a static flag to disable it:
```php
\Filisko\Tracy\RedBeanBarPanel::$showKeepCache = false; // That's all!
```
* If you would like to change the little icon of the panel or the title, use the provided static variables:
```php
\Filisko\Tracy\RedBeanBarPanel::$icon = 'src/path/icon.png'; // That's all!
\Filisko\Tracy\RedBeanBarPanel::$title = 'RedBean query logger';
```



You can have a look to RedBean's website [debugging page](http://www.redbeanphp.com/index.php?p=/debugging) to understand a little bit better the examples.

