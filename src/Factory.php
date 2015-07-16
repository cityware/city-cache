<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Cityware\Cache;

abstract class Factory
{
    /**
     * Adapter plugin manager
     * @var AdapterPluginManager
     */
    protected static $adapters;

    /**
     * @var array Known captcha types
     */
    protected static $classMap = array(
        'file' => 'Cityware\Cache\Adapter\File',
        'apc' => 'Cityware\Cache\Adapter\Apc',
        'zendserverdisk' => 'Cityware\Cache\Adapter\ZendServerDisk',
    );

    /**
     * Create a cache adapter instance
     *
     * @param string $adapter
     * @param  array|Traversable                  $options
     * @return AdapterInterface
     * @param array $options
     * @return \Cityware\Cache\Adapter\Apc|\Cityware\Cache\Adapter\File|\Cityware\Cache\Adapter\ZendServerDisk|\Cityware\Cache\Adapter\Redis|\Cityware\Cache\Adapter\Session
     * @throws \Cityware\Exception\InvalidArgumentException
     * @throws \Cityware\Exception\DomainException
     */
    public static function factory($adapter = 'file', array $options = null)
    {
        if (!is_string($adapter)) {
            throw new \Cityware\Exception\InvalidArgumentException(sprintf(
                            '%s expects an string or Traversable argument; received "%s"', __METHOD__, (is_object($adapter) ? get_class($adapter) : gettype($adapter))
            ));
        }

        if (isset(static::$classMap[strtolower($adapter)])) {
            $class = static::$classMap[strtolower($adapter)];
        }

        if (!class_exists($class)) {
            throw new \Cityware\Exception\DomainException(
                    sprintf('%s expects the "class" to resolve to an existing class; received "%s"', __METHOD__, $class)
            );
        }

        switch (strtolower($adapter)) {
            case 'file':
                return new Adapter\File($options);
                break;
            case 'apc':
                return new Adapter\Apc($options);
                break;
            case 'redis':
                return new Adapter\Redis($options);
                break;
            case 'zendserverdisk':
                return new Adapter\ZendServerDisk($options);
                break;
            case 'session':
                return new Adapter\Session($options);
                break;
            default:
                throw new \Cityware\Exception\InvalidArgumentException('Adaptador não definico');
                break;
        }
    }

}
