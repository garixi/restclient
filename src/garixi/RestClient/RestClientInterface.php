<?php
namespace garixi\RestClient;
interface RestClientInterface
{
    public function request($_type, $_method, $_parameters, $_returnFormat);
}
