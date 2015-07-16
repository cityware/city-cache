<?php

namespace Cityware\Cache\Adapter;

use Zend\Cache\StorageFactory AS ZendCache;

class Redis extends AdapterAbstract {

    public function preapareCache() {
        $cache = ZendCache::factory(array(
                    'adapter' => array(
                        'name' => 'redis',
                        'options' => array(
                            'ttl' => $this->getTtl(),
                        ),
                    ),
                    'plugins' => array(
                        'Serializer',
                        'ExceptionHandler' => array('throw_exceptions' => false),
                        'OptimizeByFactor' => array('optimizing_factor' => 0),
                        'IgnoreUserAbort' => array('exitOnAbort' => false),
                        'ClearExpiredByFactor' => array('clearing_factor' => 0),
                    ),
        ));

        $redisOptions = new \Zend\Cache\Storage\Adapter\RedisOptions();
        $redisOptions->setServer(
                array(
                    'host' => $this->getHost(),
                    'port' => $this->getPort(),
                    'timeout' => '30',
                )
        );

        $redisOptions->setLibOptions(array(\Redis::OPT_SERIALIZER => \Redis::SERIALIZER_PHP));

        $cache->setOptions($redisOptions);
        $this->setCache($cache);
    }

    public function saveCache($key, $value) {
        $this->preapareCache();
        parent::saveCache($key, $value);
    }

}
