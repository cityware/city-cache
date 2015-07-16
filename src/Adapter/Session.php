<?php

namespace Cityware\Cache\Adapter;

use Zend\Cache\StorageFactory AS ZendCache;

class Session extends AdapterAbstract {

    public function preapareCache() {
        $cache = ZendCache::factory(array(
                    'adapter' => array(
                        'name' => 'session',
                        'options' => array(
                            'ttl' => $this->getTtl(),
                            'session_container' => '',
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
        $this->preapareCache();
        parent::saveCache($key, $value);
    }

}
