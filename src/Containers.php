<?php
/*
 +-----------------------------------------------------------------------------+
 | plinker/lxd - PlinkerRPC - LXD
 +-----------------------------------------------------------------------------+
 | Copyright (c)2018 (http://github.com/plinker-rpc/lxd)
 +-----------------------------------------------------------------------------+
 | This source file is subject to MIT License
 | that is bundled with this package in the file LICENSE.
 |
 | If you did not receive a copy of the license and are unable to
 | obtain it through the world-wide-web, please send an email
 | to lawrence@cherone.co.uk so we can send you a copy immediately.
 +-----------------------------------------------------------------------------+
 | Authors:
 | - [Lawrence Cherone](http://github.com/plinker-rpc)
 +-----------------------------------------------------------------------------+
 */

namespace Plinker\Lxd;

class Containers extends Lib\Base
{
    /*
     * @var - LXD endpoint (set by base)
     */
    public $endpoint;

    /**
     *
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config, '/1.0/containers');
    }

    /**
     *
     */
    public function getState($remote = 'local', $container = '', $mutator = null)
    {
        return $this->query($remote.':'.$this->endpoint.'/'.$container.'/state', 'GET', [], $mutator);
    }

    /**
     *
     */
    public function setState($remote = 'local', $container = '', $options = [], $mutator = null)
    {
        return $this->query($remote.':'.$this->endpoint.'/'.$container.'/state', 'PUT', $options, $mutator);
    }

    /**
     *
     */
    public function start($remote = 'local', $container = '', $mutator = null)
    {
        return $this->setState($remote, $container, ['action' => 'start', 'timeout' => 30], $mutator);
    }

    /**
     *
     */
    public function stop($remote = 'local', $container = '', $mutator = null)
    {
        return $this->setState($remote, $container, ['action' => 'stop', 'timeout' => 30], $mutator);
    }

    /**
     *
     */
    public function restart($remote = 'local', $container = '', $mutator = null)
    {
        return $this->setState($remote, $container, ['action' => 'restart', 'timeout' => 30], $mutator);
    }

    /**
     *
     */
    public function freeze($remote = 'local', $container = '', $mutator = null)
    {
        return $this->setState($remote, $container, ['action' => 'freeze', 'timeout' => 30], $mutator);
    }

    /**
     *
     */
    public function unfreeze($remote = 'local', $container = '', $mutator = null)
    {
        return $this->setState($remote, $container, ['action' => 'unfreeze', 'timeout' => 30], $mutator);
    }
    
    /**
     *
     */
    public function exec($remote = 'local', $container = '', $options = [], $mutator = null)
    {
        return $this->query($remote.':'.$this->endpoint.'/'.$container.'/exec', 'POST', $options, $mutator);
    }
}
