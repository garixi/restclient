<?php
namespace lepiaf\RestClient;
interface RestClientInterface
{
    public function poke($_type, $_method);
    public function addParameter( $_parameter);
}
