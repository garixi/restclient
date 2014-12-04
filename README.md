# restclient

Client to consume REST API ressource.

## How To Use

```json
{
    "require":{
        "garixi/restclient": "dev-master"
    }
}
```

```php
$client = new RestClient("http://baseurl");
$data = $client->request(RestClient::GET, "shows/list", array());
``` 

