# yii2-cache-dogpile
Yii2 component designed for solving dogpile cache issues.

Set mutex accessor dependencies that are required by a cache class via di container.
```php
\Yii::$container->set(
    'Hexspeak\Dogpile\Caching\Mutexes\MutexAccessorInterface',
    'Hexspeak\Dogpile\Caching\Mutexes\MutexAccessor'
);
```

Specify a cache component in app configuration that will be used by dogpile component. Specify a cache class
```php
'cache' => [
      'class' => 'Hexspeak\Dogpile\Caching\Mixins\MemCache',
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
/** @var \Hexspeak\Dogpile\Caching\Mixins\MemCache $cache */
$cache = \yii::$app->cache;
$cache-> ... [set, get, etc.]
```
