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

use Plinker\Redbean\RedBean as Model;

class Containers extends Lib\Base
{
    /**
     *
     */
    public function __construct(array $config = array())
    {
        $this->config = $config;

        // load models
        $this->model = new Model($this->config['database']);
    }

    /**
     *
     */
    public function list($remote = '')
    {
        return $this->query($remote.':/1.0/containers', 'GET', []);
    }
}
