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
    
    const XML = "xml";
    const JSON = "json";
    
    const DELETE = "DELETE";
    const GET = "GET";
    const POST = "POST";
    const PUT = "PUT";
    
    private $apiKey;
    private $options;
    private $debug = false;
    public function __construct($_apiKey)
    {
        $this->apiKey = $_apiKey;    
        $this->options = $this->defaultOptions();
        $this->addOptions(CURLOPT_HTTPHEADER, array(
                "X-BetaSeries-Version: ".self::VERSION,
                "X-BetaSeries-Key: ".$this->apiKey
            )
        );
    }
    
    private function defaultOptions(){
        return array(
            CURLOPT_USERAGENT => "PHP RESTClient",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false
        );   
    }
    
    public function addOptions($_curlOption, $_valueOption){
        $this->options[$_curlOption] = $_valueOption;
    }
    
    public function request($_type, $_method,$_parameters, $_returnFormat = self::JSON)
    {
        $callUrl = self::URL.$_method;
        
        if($_type === self::DELETE){
            $this->addOptions(CURLOPT_CUSTOMREQUEST, self::DELETE);
            if(count($_parameters)>0)
            {
                $callUrl .= "?".http_build_query($_parameters);
            }
        }else if($_type == self::PUT){
            $this->addOptions(CURLOPT_PUT, true);
            $this->addOptions(CURLOPT_POST, $_parameters);
        }else if($_type === self::POST){
            $this->addOptions(CURLOPT_POST, $_parameters);
        }else{ //append parameter by default
            if(count($_parameters)>0)
            {
                $callUrl .= "?".http_build_query($_parameters);
            }
        }
        
        if($this->debug === true){
            echo $callUrl;
            var_dump($this->options);
        }
        $curlHandler = curl_init($callUrl);
        curl_setopt_array($curlHandler,$this->options);
        $response = curl_exec($curlHandler);
        curl_close($curlHandler);
        
        if($_returnFormat === self::JSON){
            return json_decode($response);
        }elseif($_returnFormat === self::XML){
            return simplexml_load_string($response);
        }  
    }
}
