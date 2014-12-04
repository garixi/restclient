<?php
namespace garixi\RestClient;
require_once("RestClientInterface.php");
/**
 *
 * @package restclient
 * @author Thierry Piaf
 **/
class RestClient implements RestClientInterface 
{

    private $baseUrl;
    
    const XML = "xml";
    const JSON = "json";
    
    const DELETE = "DELETE";
    const GET   = "GET";
    const POST = "POST";
    const PUT = "PUT";
    
    private $apiKey;
    private $options;
    private $debug = false;
    public function __construct($baseUrl)
    {
        $this->baseUrl = $baseUrl;
        $this->options = $this->defaultOptions();
    }
    
    private function defaultOptions(){
        return array(
            CURLOPT_USERAGENT => "PHP RESTClient",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false
        );   
    }
    
    public function addOptions($_CURLOption, $_valueOption){
        $this->options[$_CURLOption] = $_valueOption;
    }
    
    public function request($_type, $_method,$_parameters, $_returnFormat = self::JSON)
    {
       $callURL = self::$baseUrl.$_method;
        
        if($_type === self::DELETE){
            $this->addOptions(CURLOPT_CUSTOMREQUEST, self::DELETE);
            if(count($_parameters)>0)
            {
               $callURL .= "?".http_build_query($_parameters);
            }
        }else if($_type == self::PUT){
            $this->addOptions(CURLOPT_PUT, true);
            $this->addOptions(CURLOPT_POST, $_parameters);
        }else if($_type === self::POST){
            $this->addOptions(CURLOPT_POST, $_parameters);
        }else{ //append parameter by default
            if(count($_parameters)>0)
            {
               $callURL .= "?".http_build_query($_parameters);
            }
        }
        
        if($this->debug === true){
            echo$callURL;
            var_dump($this->options);
        }
        $CURLHandler = CURL_init($callURL);
        CURL_setopt_array($CURLHandler,$this->options);
        $response = CURL_exec($CURLHandler);
        CURL_close($CURLHandler);
        
        if($_returnFormat === self::JSON){
            return json_decode($response);
        }elseif($_returnFormat === self::XML){
            return simplexml_load_string($response);
        }  
    }
}
