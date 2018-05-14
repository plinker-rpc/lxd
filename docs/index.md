## PlinkerRPC - LXD

[![Build Status](https://travis-ci.org/plinker/lxd.svg?branch=master)](https://travis-ci.org/plinker/lxd)
[![StyleCI](https://styleci.io/repos/REPO_ID_CHANGE_THIS/shield?branch=master)](https://styleci.io/repos/REPO_ID_CHANGE_THIS)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/plinker/lxd/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/plinker/lxd/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/plinker/lxd/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/plinker/lxd/code-structure/master/code-coverage)
[![Packagist Version](https://img.shields.io/packagist/v/plinker/lxd.svg?style=flat-square)](https://github.com/plinker/lxd/releases)
[![Packagist Downloads](https://img.shields.io/packagist/dt/plinker/lxd.svg?style=flat-square)](https://packagist.org/packages/plinker/lxd)

Control LXD through RPC, heavily based upon https://github.com/lcherone/lxc-query node.js library.


## Install

Require this package with composer using the following command:

``` bash
$ composer require plinker/lxd
```

## Setup

The webserver user must be able to execute `lxc` commands, so add the user to sudoers file:

```
# User privilege specification
root     ALL=(ALL:ALL) ALL
www-data ALL=(ALL:ALL) NOPASSWD: /usr/bin/lxc
```

### Usage example:

    <?php
    require 'vendor/autoload.php';
    //
    // Insert here, how to use the package.
    

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.


## Credits

 - [Lawrence Cherone](http://github.com/plinker-rpc)
 - [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
