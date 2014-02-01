# restclient

Client to consume REST API ressource.

## How To Use

```json
{
    "require":{
        "lepiaf/restclient": "dev-master"
    }
}
```

```php
$client = new RestClient(API_KEY);
$data = $client->request(RestClient::GET, "shows/list", array());
``` 

