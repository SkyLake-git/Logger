<?php

declare(strict_types=1);

namespace Lyrica0954\Logger;

use Lyrica0954\Logger\webhook\Webhook;
use Lyrica0954\Logger\Logger;

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

    public function setContent(String $content){
        $this->content = $content;
    }

    public function appendContent(String $text){
        $this->content .= $text;
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

    public function writeToFile($path, $includePPath = false, $flags = 0){
        $instance = Logger::getInstance();
        if ($includePPath){
            $truePath = $instance->getDataFolder() . $path;
        } else {
            $truePath = $path;
        }
        touch($truePath);
        file_put_contents($truePath, $this->convertToText(), $flags);
    }

    public function sendToDiscord(String $url, Bool $async = false, String $username = "PMMP Logger", Array $embeds = array()){
        $instance = new Webhook($this->convertToText(), $url, $username, $embeds);
        return $instance->sendWebhook($async);
    }
}