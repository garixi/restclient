<?php
require_once "src/lepiaf/restclient/restclient.php";
use lepiaf\RestClient\RestClient;
$client = new RestClient("");

$mesSeries = array(
'8'=>'How I Met Your Mother',
'536'=>'Kaamelott'
);
$filename = "How.I.Met.Your.Mother.S09E16.HDTV.x264-KILLERS.mp4";
$showName=null;
$filenameExplode = explode(".", $filename);
foreach($filenameExplode as $key=>&$part){
    if(preg_match("#^S[0-9]{2}E[0-9]{2}#", $part)){
        $season = substr($part,1,2); 
        $episode = substr($part,4,2); 
        for($i=0;$i<$key;$i++){
            $showName .= $filenameExplode[$i]." " ;
        } 
             
    }
}

 

echo $showName;
var_dump($filenameExplode);

$options = array(
'id'=>8, 
'season'=>$season,
'episode' => $episode,
'subtitles'=>true
);
$data = $client->request(RestClient::GET, "shows/episodes", $options);

$options = array(
'id'=>$data->episodes[0]->id, 
'language'=>'vf',
);

$data = $client->request(RestClient::GET, "subtitles/episode", $options);
$numberMatch=0;
$listSubtitle=array();
$arrMatch=array();
foreach($data->subtitles as &$subtitle){
    foreach($filenameExplode as $part){
        if(preg_match('#'.$part.'#', $subtitle->file)){
            $numberMatch++; 
            
        }
    }
    $subtitle->match = $numberMatch;
    array_push($listSubtitle, $subtitle);
    array_push($arrMatch,$numberMatch);
    //echo $numberMatch." " .$subtitle->file."<br>";
    $numberMatch=0;
}

foreach($listSubtitle as &$subtitle){
    if($subtitle->match == max($arrMatch)){
        echo $subtitle->file."<br>";
    }
}
    
    
    
    