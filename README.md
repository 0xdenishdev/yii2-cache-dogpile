# yii2-cache-dogpile
Yii2 component designed for solving dogpile cache issues.

Set specific implementation of cache class via di container.
```php
\Yii::$container->set(
   'Hexspeak\Dogpile\Services\CacheServiceAbstract',
   'Hexspeak\Dogpile\Services\MemCacheService'
);
```

Specify a cache component in app configuration that will be used by dogpile component
```php
'cache' => [
    'class' => 'yii\caching\MemCache',
    'useMemcached' => true,
    'servers' => [
        [
            'host' => getenv('MEMCACHE_HOST'),
            'port' => getenv('MEMCACHE_PORT'),
            'weight' => 100,
        ],
    ],
],
```

Configure dogpile component.
```php
'dogpile' => [
    'class'  => '\Hexspeak\Dogpile\Cache',
    'useComponent' => 'cache',
    'mutexAccessor' => [
        'accessorClass' => '\Hexspeak\Dogpile\Mutexes\MutexAccessor',
        'timeToWait'    => 3000,
        'waitInterval'  => 300
    ],
],
```

Simple use in code via component name.
```php
/** @var \Hexspeak\Dogpile\Cache $cache */
$cache = \yii::$app->dogpile;
$cache->getCacheAccessor()-> ... [set, get, etc.]
```
