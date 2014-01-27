<?php
namespace lepiaf\RestClient;
require_once("RestClientInterface.php");
/**
 *
 * @package restclient
 * @author Thierry Piaf
 **/
class RestClient implements RestClientInterface 
{

    const URL = "https://api.betaseries.com/";
    const VERSION = "2.2";
    private $apiKey;
    private $parameters;
    
    public function __construct($_apiKey)
    {
        $this->apiKey = $_apiKey;    
    }
    
    public function addParameter($_parameter)
    {
        array_push($this->parameters, $_parameter);    
    }
    
    public function poke($_type, $_method)
    {
        $callUrl = self::URL.$_method;
        echo $callUrl;
        $curlHandler = curl_init($callUrl);
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER => array(
                "X-BetaSeries-Version: ".self::VERSION,
                "X-BetaSeries-Key: ".$this->apiKey
            )
        );
        
        curl_setopt_array($curlHandler,$options);
        $response = curl_exec($curlHandler);
        curl_close($curlHandler);
        
        return json_decode($response);  
    }
}
