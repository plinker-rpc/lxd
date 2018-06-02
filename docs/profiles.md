Helper methods for profiles.

## List

List profiles.

**Parameters & Call**

| Parameter    | Type          | Description   | Default       |
| ----------   | ------------- | ------------- | ------------- | 
| remote       | string        | LXD remote    | local         |
| mutator      | function      | Mutation function |           |

``` php
$client->lxd->profiles->list('local', function ($result) {
    return str_replace('/1.0/profiles/', '', $result);
});
```

**Response**
``` text
Array
(
    [0] => default
)
```

## Info

Get profile information.

**Parameters & Call**

| Parameter    | Type          | Description   | Default       |
| ----------   | ------------- | ------------- | ------------- | 
| remote       | string        | LXD remote    | local         |
| name         | string        | Profile name  |               |
| mutator      | function      | Mutation function |           |

``` php
$client->lxd->profiles->info('local', 'default');
```

**Response**
 
``` text
Array
(
    [config] => Array
        (
        )

    [description] => Default LXD profile
    [devices] => Array
        (
            [eth0] => Array
                (
                    [name] => eth0
                    [nictype] => bridged
                    [parent] => lxdbr0
                    [type] => nic
                )

            [root] => Array
                (
                    [path] => /
                    [pool] => default
                    [type] => disk
                )

        )

    [name] => default
    [used_by] => Array
        (
        )

)
```

## Create

Create profile.

**Parameters & Call**

| Parameter    | Type          | Description   | Default       |
| ----------   | ------------- | ------------- | ------------- | 
| remote       | string        | LXD remote    | local         |
| options      | object        | Profile options   |           |
| mutator      | function      | Mutation function |           |

``` php
$client->lxd->profiles->create('local', [
    "name" => "my-new-profile",
    "description" =>"Some informative description string",
    "config" => [
        "limits.memory" => "2GB"
    ],
    "devices" => (object) [
        "kvm" => [
            "type" => "unix-char",
            "path" =>  "/dev/kvm"
        ]
    ]
]);
```

**Response**

``` text

```

## Replace

Replace profile properties, update description, devices and limits.

**Parameters & Call**

| Parameter    | Type          | Description   | Default       |
| ----------   | ------------- | ------------- | ------------- | 
| remote       | string        | LXD remote    | local         |
| name         | string        | Profile name  |               |
| options      | object        | Profile options   |           |
| mutator      | function      | Mutation function |           |

**Note:** You should make sure `devices` property is an object :/ or your get an error: `Error: json: cannot unmarshal array into Go struct field ProfilesPost.devices of type map[string]map[string]string`

``` php
$client->lxd->profiles->replace('local', 'my-new-profile', [
    "description" =>"Some informative description string",
    "config" => [
        "limits.memory" => "4GB"
    ],
    "devices" => (object) []
]);
```

**Response**

``` text

```

## Update

Update profile properties, update description, devices and limits.

**Parameters & Call**

| Parameter    | Type          | Description   | Default       |
| ----------   | ------------- | ------------- | ------------- | 
| remote       | string        | LXD remote    | local         |
| name         | string        | Profile name  |               |
| options      | object        | Profile options   |           |
| mutator      | function      | Mutation function |           |

``` php
$client->lxd->profiles->update('local', 'my-new-profile', [
    "description" =>"Some informative description string",
    "config" => [
        "limits.memory" => "3GB"
    ]
]);
```

**Response**

``` text

```

## Rename

Rename a profile.

**Parameters & Call**

| Parameter    | Type          | Description   | Default       |
| ----------   | ------------- | ------------- | ------------- | 
| remote       | string        | LXD remote    | local         |
| name         | string        | Profile name  |               |
| newName      | string        | New profile name  |           |
| mutator      | function      | Mutation function |           |

``` php
$client->lxd->profiles->rename('local', 'my-new-profile', 'my-new-profile-1');
```

**Response**

``` json
{
	
}
```

## Delete

Delete a profile.

**Parameters & Call**

| Parameter    | Type          | Description   | Default       |
| ----------   | ------------- | ------------- | ------------- | 
| remote       | string        | LXD remote    | local         |
| name         | string        | Profile name  |               |
| mutator      | function      | Mutation function |           |

``` php
$client->lxd->profiles->delete('local', 'my-new-profile');
```

**Response**

``` json
{
	
}
```