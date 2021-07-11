<?php

declare(strict_types=1);

namespace Lyrica0954\Logger;

use Lyrica0954\Logger\webhook\Webhook;

class Log{

    private $content;
    private $time;
    private $date;
    private $format;

    public function __construct(String $content, String $format = "Y/m/d H:i:s", String $textFormat = "[%s] %s"){
        $this->content = $content;
        $this->time = microtime(true);
        $this->date = date($format);
        $this->format = $textFormat;
    }

    public function getContent(){
        return $this->content;
    }

    public function getMicrotime(){
        return $this->time;
    }

    public function getDate(){
        return $this->date;
    }

    public function convertToText(){
        return sprintf($this->format, $this->date, $this->content);
    }

    public function writeToFile($path, $includePPath = false){
        if ($includePPath){
            $truePath = $this->getDataFolder() . $path;
        } else {
            $truePath = $path;
        }
        file_put_contents($path, $this->convertToText());
    }

    public function sendToDiscord($url, $async = false, $username = "PMMP Logger"){
        $instance = new Webhook($this->convertToText(), $url, $username);
        return $instance->sendWebhook($async);
    }
}