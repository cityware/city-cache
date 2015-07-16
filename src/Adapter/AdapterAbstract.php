<?php

namespace Cityware\Cache\Adapter;

use \Exception;

abstract class AdapterAbstract {

    private $ttl, $cacheDir, $cache, $host, $port, $moduleName, $controllerName;

    public function getModuleName() {
        return $this->moduleName;
    }

    public function getControllerName() {
        return $this->controllerName;
    }

    public function setModuleName($moduleName) {
        $this->moduleName = $moduleName;
    }

    public function setControllerName($controllerName) {
        $this->controllerName = $controllerName;
    }

    public function getHost() {
        return $this->host;
    }

    public function getPort() {
        return $this->port;
    }

    public function setHost($host) {
        $this->host = $host;
    }

    public function setPort($port) {
        $this->port = $port;
    }

    public function getCache() {
        return $this->cache;
    }

    public function setCache($cache) {
        $this->cache = $cache;
    }

    public function getTtl() {
        return (empty($this->ttl)) ? 3600 : $this->ttl;
    }

    public function setTtl($ttl) {
        $this->ttl = $ttl;
    }
    
    abstract public function preapareCache();

    public function getCacheDir() {
        if (empty($this->cacheDir)) {
            try {
                if (!file_exists(CACHE_PATH . $this->moduleName . DS . $this->controllerName)) {
                    mkdir(CACHE_PATH . $this->moduleName . DS . $this->controllerName, 0777, true);
                    chmod(CACHE_PATH . $this->moduleName . DS . $this->controllerName, 0777);
                }

                $this->cacheDir = CACHE_PATH . $this->moduleName . DS . $this->controllerName;
            } catch (Exception $exc) {
                throw new Exception('Erro ao tentar criar pastas de cache do sistema!' . $exc->getMessage(), 500);
            }
        }

        return $this->cacheDir;
    }

    public function setCacheDir($cacheDir) {
        $this->cacheDir = $cacheDir;
    }

    public function createCacheId($id) {
        $cacheId = md5(base64_encode($id));

        return $cacheId;
    }

    public function clearByCachedId($key) {
        return $this->cache->removeItem($key);
    }

    public function verifyCache($key) {
        return $this->cache->hasItem($key);
    }

    public function getCacheContent($key) {
        return $this->cache->getItem($key);
    }

    public function saveCache($key, $value) {
        return $this->cache->addItem($key, $value);
    }

}
