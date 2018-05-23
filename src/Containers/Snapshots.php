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

namespace Plinker\Lxd\Containers;

class Snapshots extends \Plinker\Lxd\Lib\Base
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
    public function list($remote = 'local', $container = '', $mutator = null)
    {
        return $this->query($remote.':'.$this->endpoint.'/'.$container.'/snapshots', 'GET', [], $mutator);
    }

    /**
     *
     */
    public function info($remote = 'local', $container = '', $name = '', $mutator = null)
    {
        return $this->query($remote.':'.$this->endpoint.'/'.$container.'/snapshots/'.$name, 'GET', [], $mutator);
    }
    
    /**
     *
     */
    public function create($remote = 'local', $container = '', $options = [], $mutator = null)
    {
        return $this->query($remote.':'.$this->endpoint.'/'.$container.'/snapshots', 'POST', $options, $mutator);
    }

    /**
     *
     */
    public function rename($remote = 'local', $container = '', $name = '', $newName = '', $mutator = null)
    {
        return $this->query($remote.':'.$this->endpoint.'/'.$container.'/snapshots/'.$name, 'POST', ['name' => $newName], $mutator);
    }

    /**
     *
     */
    public function delete($remote = 'local', $container = '', $name = '', $mutator = null)
    {
        return $this->query($remote.':'.$this->endpoint.'/'.$container.'/snapshots/'.$name, 'DELETE', [], $mutator);
    }
    
    /**
     *
     */
    public function restore($remote = 'local', $container = '', $name = '', $mutator = null)
    {
        return $this->query($remote.':'.$this->endpoint.'/'.$container, 'PUT', ['restore' => $name], $mutator);
    }
}
