<?php
require_once "src/lepiaf/restclient/restclient.php";
use lepiaf\restclient\restclient;
$client = new restclient("");
var_dump($client->poke("GET", "shows/list"));