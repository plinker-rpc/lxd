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

class Images extends Lib\Base
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
        parent::__construct($config, '/1.0/images');
    }

    /**
     *
     */
    public function remotes()
    {
        return $this->local('lxc remote list', function ($response = '') {
            //
            $response = trim($response);
            
            if (empty($response)) {
                return [];
            }
            
            // match out table data
            preg_match_all('#\| +(.*?) +\| +(.*?) +\| +(.*?) +\| +(.*?) +\| +(.*?) +\| +(.*?) +\|#', $response, $matches);

            // remove full match
            unset($matches[0]);
            $matches = array_values($matches);

            // flip matches into nromal array
            $result = [];
            foreach ($matches as $key => $subarr) {
                foreach ($subarr as $subkey => $subvalue) {
                    // switch YES|NO for true/false
                    $subvalue = in_array($subvalue, ['YES', 'NO']) ? ($subvalue === 'YES') : $subvalue;
                    //
                    $subvalue = str_replace('(default)', '', $subvalue);
                    
                    $result[$subkey][$key] = trim($subvalue);
                }
            }

            // lowercase header values reaplce space with _
            $result[0] = array_map(function ($value) {
                return str_replace(' ', '_', strtolower($value));
            }, $result[0]);

            // loop over and use head values as the array keys
            foreach ($result as $key => $value) {
                $result[$key] = array_combine($result[0], $value);
            }

            // remove head and reset keys and return
            unset($result[0]);
            //
            return array_values($result);
        });
    }

    /**
     *
     */
    public function list($remote = 'local', $filter = null, $mutator = null)
    {
        return $this->local('lxc image list '.escapeshellarg($remote).': '.$filter.' --format=json', $mutator);
    }
}
