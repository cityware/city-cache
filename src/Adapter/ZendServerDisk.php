<?php

namespace Cityware\Cache\Adapter;

use Zend\Cache\StorageFactory AS ZendCache;

class ZendServerDisk extends AdapterAbstract {

    public function preapareCache() {
        $cache = ZendCache::factory(array(
                    'adapter' => array(
                        'name' => 'zendserverdisk',
                        'options' => array(
                            'ttl' => $this->getTtl(),
                        ),
                    ),
                    'plugins' => array(
                        'Serializer',
                        'ExceptionHandler' => array('throw_exceptions' => false),
                        'OptimizeByFactor' => array('optimizing_factor' => 0),
                        'IgnoreUserAbort' => array('exitOnAbort' => true),
                        'ClearExpiredByFactor' => array('clearing_factor' => 0),
                    ),
        ));
        $this->setCache($cache);
    }

    public function saveCache($key, $value) {
        $this->preapareCache();
        parent::saveCache($key, $value);
    }

}
