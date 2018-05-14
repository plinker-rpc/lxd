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

use Plinker\Redbean\RedBean as Model;

class Files extends \Plinker\Lxd\Lib\Base
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
     /*
    public function list($remote = 'local', $container = '', $mutator = null)
    {
        return $this->query($remote.':'.$this->endpoint.'/'.$container.'/snapshots', 'GET', [], $mutator);
    }
    */
}
