Helper methods for image.

## Remotes

List image remotes.

**Parameters & Call**

| Parameter    | Type          | Description   | Default       |
| ----------   | ------------- | ------------- | ------------- | 
| mutator      | function      | Mutation function |           |

``` php
$client->lxd->images->remotes();
```

**Response**
``` json
images
local
ubuntu
ubuntu-daily
```

**As an array:**

``` php
$client->lxd->images->remotes(function ($result) {
    return explode(PHP_EOL, $result);
})
```

**Response**
``` json
Array
(
    [0] => images
    [1] => local
    [2] => ubuntu
    [3] => ubuntu-daily
)
```

## List

List images on remote.

**Parameters & Call**

| Parameter    | Type          | Description   | Default       |
| ----------   | ------------- | ------------- | ------------- | 
| remote       | string        | LXD remote    | local         |
| filter       | string        | Image property based filtering | |
| mutator      | function      | Mutation function |           |

``` php
$client->lxd->images->list('images');

// filtering by architecture
$client->lxd->images->list('images', 'architecture="'.implode('|', ['x86_64', 'i686', 'amd64']).'"');
```

**Response**
``` json
Array
(
    [0] => Array
        (
            [auto_update] => 
            [properties] => Array
                (
                    [architecture] => amd64
                    [description] => Alpine 3.4 amd64 (20180523_17:50)
                    [os] => Alpine
                    [release] => 3.4
                    [serial] => 20180523_17:50
                )

            [public] => 1
            [aliases] => Array
                (
                    [0] => Array
                        (
                            [name] => alpine/3.4/default
                            [description] => 
                        )

                    [1] => Array
                        (
                            [name] => alpine/3.4/default/amd64
                            [description] => 
                        )

                    [2] => Array
                        (
                            [name] => alpine/3.4
                            [description] => 
                        )

                    [3] => Array
                        (
                            [name] => alpine/3.4/amd64
                            [description] => 
                        )

                )

            [architecture] => x86_64
            [cached] => 
            [filename] => lxd.tar.xz
            [fingerprint] => 9bf0d1672ddcca0d8e1b792b8beec335751f31118abeb65883ef4df6b995c79c
            [size] => 2134612
            [created_at] => 2018-05-23T00:00:00Z
            [expires_at] => 1970-01-01T00:00:00Z
            [last_used_at] => 0001-01-01T00:00:00Z
            [uploaded_at] => 2018-05-23T00:00:00Z
        )
   ... snip
```

## Info

Get image information.

**Parameters & Call**

| Parameter    | Type          | Description   | Default       |
| ----------   | ------------- | ------------- | ------------- | 
| remote       | string        | LXD remote    | local         |
| fingerprint  | string        | Image fingerprint |           |
| mutator      | function      | Mutation function |           |

``` php
$client->lxd->images->info('local', 'be7cec7c948958adfbb9bc7dbd292762d2388cc883466815fc2b6bc06bf06f5a');
```

**Response**

``` json
Array
(
    [aliases] => Array
        (
        )

    [architecture] => x86_64
    [auto_update] => 1
    [cached] => 1
    [created_at] => 2018-05-22T00:00:00Z
    [expires_at] => 2021-04-21T00:00:00Z
    [filename] => ubuntu-16.04-server-cloudimg-amd64-lxd.tar.xz
    [fingerprint] => 08bbf441bb737097586e9f313b239cecbba96222e58457881b3718c45c17e074
    [last_used_at] => 2018-05-21T19:20:53Z
    [properties] => Array
        (
            [architecture] => amd64
            [description] => ubuntu 16.04 LTS amd64 (release) (20180522)
            [label] => release
            [os] => ubuntu
            [release] => xenial
            [serial] => 20180522
            [version] => 16.04
        )

    [public] => 
    [size] => 165077840
    [update_source] => Array
        (
            [alias] => default
            [certificate] => 
            [protocol] => simplestreams
            [server] => https://cloud-images.ubuntu.com/releases
        )

    [uploaded_at] => 2018-05-22T19:18:20Z
)
```

## Replace

Replace image properties, update information and visibility.

**Parameters & Call**

| Parameter    | Type          | Description   | Default       |
| ----------   | ------------- | ------------- | ------------- | 
| remote       | string        | LXD remote    | local         |
| fingerprint  | string        | Image fingerprint |           |
| options      | object        | Images options    |           |
| mutator      | function      | Mutation function |           |

``` php
$client->lxd->images->replace('local', 'be7cec7c948958adfbb9bc7dbd292762d2388cc883466815fc2b6bc06bf06f5a', [
    "auto_update" => true,
    "properties" => [
        "architecture" => "x86_64",
        "description" => "Ubuntu 16.04 LTS server (20160201)",
        "os" => "ubuntu",
        "release" => "trusty"
    ],
    "public" => true
]);
```

**Response**

``` json
{
	
}
```

## Update

Update image properties, update information and visibility.

**Parameters & Call**

| Parameter    | Type          | Description   | Default       |
| ----------   | ------------- | ------------- | ------------- | 
| remote       | string        | LXD remote    | local         |
| fingerprint  | string        | Image fingerprint |           |
| options      | object        | Images options    |           |
| mutator      | function      | Mutation function |           |

``` php
$client->lxd->images->update('local', 'be7cec7c948958adfbb9bc7dbd292762d2388cc883466815fc2b6bc06bf06f5a', [
    "auto_update" => true,
    "properties" => [
        "architecture" => "x86_64",
        "description" => "Ubuntu 16.04 LTS server (20160201)",
        "os" => "ubuntu",
        "release" => "trusty"
    ],
    "public" => true
]);
```

**Response**

``` json
{
	
}
```

## Delete

Delete an image.

**Parameters & Call**

| Parameter    | Type          | Description   | Default       |
| ----------   | ------------- | ------------- | ------------- | 
| remote       | string        | LXD remote    | local         |
| fingerprint  | string        | Image fingerprint |           |
| mutator      | function      | Mutation function |           |

``` php
$client->lxd->images->delete('local', 'be7cec7c948958adfbb9bc7dbd292762d2388cc883466815fc2b6bc06bf06f5a');
```

**Response**

``` json
{
	
}
```