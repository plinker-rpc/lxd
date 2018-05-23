Helper methods for operations.

## List

List operations on remote.

**Parameters & Call**

| Parameter    | Type          | Description   | Default       |
| ----------   | ------------- | ------------- | ------------- | 
| remote       | string        | LXD remote    | local         |
| mutator      | function      | Mutation function |           |

``` php
$client->lxd->operations->list('local');
```

**Response**
``` json
Array
(
    [running] => Array
        (
            [0] => /1.0/operations/7613f4a5-13f5-474f-a086-1234e7cc3ec6
            [1] => /1.0/operations/a8be2d85-5c02-4266-b64a-de5ad97de339
        )

    [success] => Array
        (
            [0] => /1.0/operations/e5c6cc49-b100-4d12-88e8-d083949e43fc
        )

)
```

## Info

Get operation information.

**Parameters & Call**

| Parameter    | Type          | Description   | Default       |
| ----------   | ------------- | ------------- | ------------- | 
| remote       | string        | LXD remote    | local         |
| uuid         | string        | Operation uuid    |           |
| mutator      | function      | Mutation function |           |

``` php
$client->lxd->operations->info('local', '092a8755-fd90-4ce4-bf91-9f87d03fd5bc');
```

**Response**

``` json
Array
(
    [class] => websocket
    [created_at] => 2018-05-23T19:10:51.307129722Z
    [description] => Executing command
    [err] => 
    [id] => 7613f4a5-13f5-474f-a086-1234e7cc3ec6
    [may_cancel] => 
    [metadata] => Array
        (
            [fds] => Array
                (
                    [0] => 6c7104e0807487790848c7265e8f5dcfc4fe9aa05b18140f939c2c255480e77a
                    [control] => b9e05084e48bd785816ddd162242630973538a2811e5cf7a71dc7b4f2ea116f2
                )

        )

    [resources] => Array
        (
            [containers] => Array
                (
                    [0] => /1.0/containers/touching-clam
                )

        )

    [status] => Running
    [status_code] => 103
    [updated_at] => 2018-05-23T19:10:51.307129722Z
)
```

### List & Info Example

If your going to list/display opperations in a table, you might call both methods like the following using a mutator:

``` php
$client->lxd->operations->list('local', function ($result) use ($client) {
    $return = [];
    foreach ($result as $type => $operations) {
        $return[$type] = [];
        foreach ($operations as $operation) {
            $row = str_replace('/1.0/operations/', '', $operation);  
            $return[$type][] = $client->lxd->operations->info('local', $row);
        }
    }
    return $return;
})
```
**Response**

``` json
Array
(
    [running] => Array
        (
            [0] => Array
                (
                    [class] => websocket
                    [created_at] => 2018-05-23T19:10:51.307129722Z
                    [description] => Executing command
                    [err] => 
                    [id] => 7613f4a5-13f5-474f-a086-1234e7cc3ec6
                    [may_cancel] => 
                    [metadata] => Array
                        (
                            [fds] => Array
                                (
                                    [0] => 6c7104e0807487790848c7265e8f5dcfc4fe9aa05b18140f939c2c255480e77a
                                    [control] => b9e05084e48bd785816ddd162242630973538a2811e5cf7a71dc7b4f2ea116f2
                                )

                        )

                    [resources] => Array
                        (
                            [containers] => Array
                                (
                                    [0] => /1.0/containers/my-container
                                )

                        )

                    [status] => Running
                    [status_code] => 103
                    [updated_at] => 2018-05-23T19:10:51.307129722Z
                )

            [1] => Array
                (
                    [class] => websocket
                    [created_at] => 2018-05-23T19:09:33.287695819Z
                    [description] => Executing command
                    [err] => 
                    [id] => a8be2d85-5c02-4266-b64a-de5ad97de339
                    [may_cancel] => 
                    [metadata] => Array
                        (
                            [fds] => Array
                                (
                                    [0] => f25adabf27641a58cf4ed77ba00645a43e30bb6ebc9b40653a121e3f0520d302
                                    [control] => 9aa9b33243fc37d5fe742dee87afaa55ed0677c528b12f8572c91d58403333f6
                                )

                        )

                    [resources] => Array
                        (
                            [containers] => Array
                                (
                                    [0] => /1.0/containers/my-container
                                )

                        )

                    [status] => Running
                    [status_code] => 103
                    [updated_at] => 2018-05-23T19:09:33.287695819Z
                )

        )

    [success] => Array
        (
            [0] => Array
                (
                    [class] => task
                    [created_at] => 2018-05-23T19:20:20.372259879Z
                    [description] => Starting container
                    [err] => 
                    [id] => 05a5a0de-f47f-4929-86f1-817e1cf7730b
                    [may_cancel] => 
                    [metadata] => 
                    [resources] => Array
                        (
                            [containers] => Array
                                (
                                    [0] => /1.0/containers/my-container
                                )

                        )

                    [status] => Success
                    [status_code] => 200
                    [updated_at] => 2018-05-23T19:20:20.372259879Z
                )

        )

)
```


## Delete

Delete an operation.

**Parameters & Call**

| Parameter    | Type          | Description   | Default       |
| ----------   | ------------- | ------------- | ------------- | 
| remote       | string        | LXD remote    | local         |
| uuid         | string        | Operation uuid    |           |
| mutator      | function      | Mutation function |           |

``` php
$client->lxd->operations->delete('local', '092a8755-fd90-4ce4-bf91-9f87d03fd5bc');
```

**Response**

``` json
{
	
}
```

## Websocket

Websocket upgrading to `/1.0/operations/<uuid>/websocket` can be done by calling 
[`lxd->containers->exec()`](https://plinker-rpc.github.io/lxd/containers/#exec) 
with `"wait-for-websocket": true` then using the operation id to directly initialise 
the websocket connection to the LXD server using the provided secret. 

You could still use `lxd->query()` if you require it but you would need to 
proxy it through with websockets, for that reason, it has not been added 
as I do not want to add additional dependencies for a single endpoint.