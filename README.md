# yii2-cache-dogpile
Yii2 component designed for solving dogpile cache issues.

Set mutex accessor dependencies that are required by a cache class via di container.
```php
\Yii::$container->set(
    'Oxhexspeak\Dogpile\Caching\Mutexes\MutexAccessorInterface',
    'Oxhexspeak\Dogpile\Caching\Mutexes\MutexAccessor'
);
```

Specify a cache component in app configuration that will be overriden by anti dogpile component.
```php
'cache' => [
      'class' => 'Oxhexspeak\Dogpile\Caching\Mixins\MemCache',
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

Simple use in code via component name.
```php
/** @var \Oxhexspeak\Dogpile\Caching\Mixins\MemCache $cache */
$cache = \yii::$app->cache;
$cache->getSafe('some_key', function() {
    // Do some heavy stuff.
    return $result;
});
```
