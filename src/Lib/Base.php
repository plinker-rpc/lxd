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

namespace Plinker\Lxd\Lib;

use Plinker\Redbean\RedBean as Model;

class Base
{
    /*
     * @var - Component config
     */
    public $config;
    
    /*
     * @var - Plinker\Redbean\RedBean
     */
    public $model;
    
    /*
     * @var - LXD endpoint
     */
    public $endpoint;
    
    /**
     *
     */
    public function __construct(array $config = [], $endpoint = '/1.0')
    {
        // set config
        $this->config = $config;

        // load models
        $this->model = new Model($this->config['database']);
        
        // set endpoint
        $this->endpoint = $endpoint;
    }
    
    /**
     * Validate string is json, will be moved out into own class
     */
    private function json_validate($str, $return_array = false)
    {
        // decode the JSON data
        $result = json_decode($str, $return_array);

        // switch and check possible JSON errors
        switch (json_last_error()) {
            case JSON_ERROR_NONE: {
                $error = ''; // JSON is valid
            } break;

            case JSON_ERROR_DEPTH: {
                $error = 'The maximum stack depth has been exceeded.';
            } break;

            case JSON_ERROR_STATE_MISMATCH: {
                $error = 'Invalid or malformed JSON.';
            } break;

            case JSON_ERROR_CTRL_CHAR: {
                $error = 'Control character error, possibly incorrectly encoded.';
            } break;

            case JSON_ERROR_SYNTAX: {
                $error = 'Syntax error, malformed JSON.';
            } break;

                // PHP >= 5.3.3
            case JSON_ERROR_UTF8: {
                $error = 'Malformed UTF-8 characters, possibly incorrectly encoded.';
            } break;

                // PHP >= 5.5.0
            case JSON_ERROR_RECURSION: {
                $error = 'One or more recursive references in the value to be encoded.';
            } break;

                // PHP >= 5.5.0
            case JSON_ERROR_INF_OR_NAN: {
                $error = 'One or more NAN or INF values in the value to be encoded.';
            } break;

            case JSON_ERROR_UNSUPPORTED_TYPE: {
                $error = 'A value of a type that cannot be encoded was given.';
            } break;

            default: {
                $error = 'Unknown JSON error occured.';
            } break;
        }

        if ($error !== '') {
            throw new \Exception($error);
            return false;
        }

        return $result;
    }

    /**
     *
     */
    public function query($remote = 'local:/', $action = 'GET', $data = [], $mutator = null)
    {
        $remote = escapeshellarg($remote);
        $action = escapeshellarg($action);
        
        if (!is_array($data)) {
            throw new \Exception('Data argument (3rd param) must be an array');
        } elseif (!empty($data)) {
            $data = ' -d '.escapeshellarg(json_encode($data));
        } else {
            $data = '';
        }
        
        exec("sudo /usr/bin/lxc query -X $action $data $remote", $output, $status_code);
        
        // cmd executed successfully, decode json into an array or return as-is
        if ($status_code === 0) {
            try {
                $output = implode("\n", $output);
                $return = $this->json_validate($output, true);
            } catch (\Exception $e) {
                return $output;
            }
            
            // run mutation if not null
            if ($mutator !== null) {
                $return = $mutator($return);
            }
            
            return $return;
        }
        
        throw new \Exception("Could not execute: sudo /usr/bin/lxc query -X $action $data $remote", $status_code);
    }
    
    /**
     *
     */
    public function list()
    {
    }

    /**
     *
     */
    public function info()
    {
    }

    /**
     *
     */
    public function create()
    {
    }

    /**
     *
     */
    public function replace()
    {
    }

    /**
     *
     */
    public function update()
    {
    }

    /**
     *
     */
    public function rename()
    {
    }
    
    /**
     *
     */
    public function delete()
    {
    }
}
