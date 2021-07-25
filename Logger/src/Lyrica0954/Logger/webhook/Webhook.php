<?php

declare(strict_types=1);

namespace Lyrica0954\Logger\webhook;

use Lyrica0954\Logger\event\WebhookSendEvent;
use Lyrica0954\Logger\async\WebhookSendQueue;

use Lyrica0954\Logger\discord\Embed;

class Webhook{


    private $username;
    private $message;
    private $url;
    private $embeds;

    public function __construct(String $message, String $url, String $username = "PMMP Logger", Array $embeds = array()){
        $this->message = $message;
        $this->url = $url;
        $this->username = $username;
        $this->embeds = $embeds;
    }

    public function getMessage(){
        return $this->message;
    }

    public function getWebhookUrl(){
        return $this->url;
    }

    public function getEmbeds(){
        return $this->embeds;
    }

    public function hasEmbed(){
        return count($this->embeds) >= 1;
    }


    public function sendWebhook(Bool $async = false){
        if ($async){
            return WebhookSendQueue::addQueue($this);
        } else {
            $event = new WebhookSendEvent($this);
            $event->call();
            if (!$event->isCancelled()){
                $webhook_url = $this->url;
                $content = $this->messageConvert();
                $options = array(
                  'http' => array(
                    'method' => 'POST',
                    'header' => 'Content-Type: application/json',
                    'content' => json_encode($content),
                    
                  )
                );
                try{
                    $stream =  stream_context_create($options);
                    $response = file_get_contents($webhook_url, false, $stream);
                } catch (\Exception $e) {
                    return null;
                }
                return $response === 'ok';
            } 
            return false;
        }
    }

    public function addEmbed(Embed $embed){
        $this->embeds[] = $embed;
    }
    
    public function setEmbeds(Array $embeds){
        $this->embeds = $embeds;
    }

    public function messageConvert(){
        $message = array(
            'username' => $this->username, 
            'content' => $this->message,
            "embeds"=>array(

            )
        );


        foreach($this->embeds as $embed){
            if ($embed instanceof Embed){
                $message["embeds"][] = $embed->export();
            }
        }
        return $message;
    }


}