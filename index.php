<?php
require_once "src/lepiaf/restclient/restclient.php";
use lepiaf\RestClient\RestClient;
$client = new RestClient();
var_dump($client->poke("GET", "shows/list"));