# RedBean queries logger for Tracy
With this you will be able to see your logged queries with RedBean, this little package also provides a PSR-7 middleware if you're using frameworks like Slim, Silex, or whatever.

## Install
To install it you can use Composer:

`composer require filisko/tracy-redbean`

Something very important is to say to RedBean to log your queries, to do that, you must enable RedBean's debug mode.
```php
/*
Possible log modes:
-------------------
0 Log and write to STDOUT classic style (default)
1 Log only, class style
2 Log and write to STDOUT fancy style
3 Log only, fancy style (recommended)
*/
R::debug(TRUE, 3);
```


## How to use

#### Basic example

##### Parameters:
1. **$logger**: Instance of your RedBean logger, you will probably put something very similar to what is in the example.
2. **$keep_cache** (default: false): Show or not "-- keep-cache" of RedBean's queries.
3. **$icon**: Custom base64 encoded 16x16 image for the panel.
4. **$title**: Custom title.


```php
$logger = R::getDatabaseAdapter()->getDatabase()->getLogger();
$panel = new \Filisko\Tracy\RedBeanBarPanel($logger, true);
\Tracy\Debugger::getBar()->addPanel($panel);
```

#### Middleware example
##### Parameters:
1. **$tracy_bar**: Instance of your Tracy bar.
2. **$rb**: Instance of your RedBean's database adapter.
3. **$config**: It accepts from parameter 2 to 5 of previous example.

```php
$tracy_bar = \Tracy\Debugger::getBar();
$db = R::getDatabaseAdapter()->getDatabase();
$config = [
    'keep_cache' => true
];
$app->add(new \Filisko\Tracy\RedBeanBarPanelMiddleware($tracy_bar, $db, $config));
```

You can have a look to RedBean's website [debugging page](http://www.redbeanphp.com/index.php?p=/debugging) to understand a little bit better the examples.

