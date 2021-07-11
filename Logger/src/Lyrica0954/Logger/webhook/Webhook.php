<?php

declare(strict_types=1);

namespace Lyrica0954\Logger\webhook;

use Lyrica0954\Logger\event\WebhookSendEvent;
use Lyrica0954\Logger\async\WebhookSendQueue;

class Webhook{


    private $username;
    private $message;
    private $url;

    public function __construct(String $message, String $url, String $username = "PMMP Logger"){
        $this->message = $message;
        $this->url = $url;
        $this->username = $username;
    }

    public function sendWebhook($async = false){
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
                $response = file_get_contents($webhook_url, false, stream_context_create($options));
                return $response === 'ok';
            } 
            return false;
        }
    }

    public function messageConvert(){
        $message = array(
            'username' => $this->username, 
            'content' => $this->message
        );
        return $message;
    }


}