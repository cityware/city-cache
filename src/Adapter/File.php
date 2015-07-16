<?php

namespace Cityware\Cache\Adapter;

use Zend\Cache\StorageFactory AS ZendCache;

class File extends AdapterAbstract {

    public function preapareCache() {
        $cache = ZendCache::factory(array(
                    'adapter' => array(
                        'name' => 'filesystem',
                        'options' => array(
                            'ttl' => $this->getTtl(),
                            'cacheDir' => $this->getCacheDir(),
                            'dirPermission' => 0755,
                            'filePermission' => 0644,
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
        $this->setCache($cache);
    }

    public function saveCache($key, $value) {
        parent::saveCache($key, $value);
    }

}
