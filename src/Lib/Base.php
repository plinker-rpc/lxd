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

class Base
{
    /*
     * @var - Component config
     */
    public $config;

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
  
        // check lxc path or revert to default
        if (empty($this->config['lxc_path'])) {
            $this->config['lxc_path'] = '/snap/bin';
        }

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
            $data = json_encode($data);
            
            // fix devices should be empty object {} not array but FORCE_OBJECT then breaks arrays, like profiles
            $data = str_replace('"devices":[]', '"devices":{}', $data);

            $data = ' -d '.escapeshellarg($data);
        } else {
            $data = '';
        }

        exec("sudo ".$this->config['lxc_path']."/lxc query -X $action $data $remote 2>&1", $output, $status_code);
        
        // cmd executed successfully, decode json into an array or return as-is
        if ($status_code === 0) {
            try {
                $output = trim(implode(PHP_EOL, $output));
                $return = $this->json_validate($output, true);
            } catch (\Exception $e) {
                $return = $output;
            }
            
            // run mutation if not null
            if ($mutator !== null) {
                $return = $mutator($return);
            }
            
            return $return;
        } else {
            $output = trim(implode(PHP_EOL, $output));
            
            if (empty($output)) {
                $output = "Could not execute: sudo ".$this->config['lxc_path']."/lxc query -X $action $data $remote";
            }
        }

        throw new \Exception($output, $status_code);
    }
    
    /**
     * Local - execute a local command, E.G: lxc list --format="json"
     */
    public function local($cmd = '', $mutator = null)
    {
        exec("sudo ".$this->config['lxc_path']."/$cmd 2>&1", $output, $status_code);
        
        // cmd executed successfully, decode json into an array or return as-is
        if ($status_code === 0) {
            try {
                $output = trim(implode(PHP_EOL, $output));
                $return = $this->json_validate($output, true);
            } catch (\Exception $e) {
                $return = $output;
            }
            
            // run mutation if not null
            if ($mutator !== null) {
                $return = $mutator($return);
            }
            
            return $return;
        } else {
            $output = trim(implode(PHP_EOL, $output));
            
            if (empty($output)) {
                $output = "Could not execute: sudo ".$this->config['lxc_path']."/".$cmd;
            }
        }

        throw new \Exception($output, $status_code);
    }
    
    /**
     *
     */
    public function list($remote = 'local', $mutator = null)
    {
        return $this->query($remote.':'.$this->endpoint, 'GET', [], $mutator);
    }

    /**
     *
     */
    public function info($remote = 'local', $name = '', $mutator = null)
    {
        return $this->query($remote.':'.$this->endpoint.'/'.$name, 'GET', [], $mutator);
    }

    /**
     *
     */
    public function create($remote = 'local', $options = [], $mutator = null)
    {
        return $this->query($remote.':'.$this->endpoint, 'POST', $options, $mutator);
    }

    /**
     *
     */
    public function replace($remote = 'local', $name = '', $options = [], $mutator = null)
    {
        return $this->query($remote.':'.$this->endpoint.'/'.$name, 'PUT', $options, $mutator);
    }

    /**
     *
     */
    public function update($remote = 'local', $name = '', $options = [], $mutator = null)
    {
        return $this->query($remote.':'.$this->endpoint.'/'.$name, 'PATCH', $options, $mutator);
    }

    /**
     *
     */
    public function rename($remote = 'local', $name = '', $newName = '', $mutator = null)
    {
        return $this->query($remote.':'.$this->endpoint.'/'.$name, 'POST', ['name' => $newName], $mutator);
    }

    /**
     *
     */
    public function delete($remote = 'local', $name = '', $mutator = null)
    {
        return $this->query($remote.':'.$this->endpoint.'/'.$name, 'DELETE', [], $mutator);
    }
}
