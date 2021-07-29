<?php

declare(strict_types=1);

namespace Lyrica0954\Logger\webhook;

use pocketmine\Server;

class WebhookResponse{

    public const RESPONSE_ERROR = 0;
    public const RESPONSE_NOTHING = 1;
    public const RESPONSE_SUCCESS = 2;
    public const RESPONSE_CANCELLED = 3;
    public const RESPONSE_FAILED = 4;

    private $status;
    private $response;
    private $text;

    public function __construct(Int $status, String $response, String $text){
        $this->status = $status;
        $this->response = $response;
        $this->text = $text;
    }

    public function getStatus(){
        return $this->status;
    }

    public function getResponse(){
        return $this->response;
    }

    public function getText(){
        return $this->text;
    }

    public function setText(String $text){
        $this->text = $text;
    }

    public function success(){
        return ($this->status !== self::RESPONSE_FAILED) &&
               ($this->status !== self::RESPONSE_NOTHING) &&
               ($this->status !== self::RESPONSE_ERROR);
    }


    public function log($format = "%s§7(%s §6%s§7)"){
        $logger = Server::getInstance()->getLogger();
        switch($this->status){
            case self::RESPONSE_ERROR:
                $text = sprintf($format, $this->getText(), "Error", $this->getResponse());
                $logger->warning("§a[Logger] §c{$text}");
                break;
            case self::RESPONSE_NOTHING:
                $text = sprintf($format, $this->getText(), "No Response", "");
                $logger->notice("§a[Logger] §7{$text}");
                break;
            case self::RESPONSE_SUCCESS:
                $text = sprintf($format, $this->getText(), "No Response", "");
                $logger->info("§a[Logger] §a{$text}");
                break;
            case self::RESPONSE_CANCELLED:
                $text = sprintf($format, $this->getText(), "Cancelled", "");
                $logger->info("§a[Logger] §7{$text}");
                break;
            case self::RESPONSE_FAILED:
                $text = sprintf($format, $this->getText(), "Response", $this->getResponse());
                $logger->warning("§a[Logger] §7{$text}");
                break;  
        }
    }
}