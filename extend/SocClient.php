<?php
require_once G5_PATH."/vendor/autoload.php";
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;


class SocClient {


    private $sslOption = [
                'context' => [
                            'ssl' => [
                            'verify_peer' => false,
                            'verify_peer_name' => false
                            ]
                ]
            ];

    private $client;


    public  function __construct($serverUrl,$namespace){
        $engine = "";
        if(isContains("https",$serverUrl)) {
            $engine = new Version2X($serverUrl, $this->sslOption);
        } else {
            $engine = new Version2X($serverUrl);
        }


        $this->client = new Client($engine);
        $this->client->initialize();


        // namespace 접근
        if(!empty($namespace))
            $this->client->of("/".$namespace);


    }

    public function emit($event,$msg)
    {
        if(is_object($msg)){
            $msg = get_object_vars($msg);
        } elseif(!is_array($msg)){
            $msg = [$msg]; // 메세지는 배열타입이 아닐경우 오류를 발생시킨다.
        }

        $this->client->emit($event,$msg);
    }

    public function disconnect(){
            $this->client->close();
    }

    function __destruct(){
        $this->disconnect();
    }


}