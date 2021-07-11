<?php

declare(strict_types=1);

namespace Lyrica0954\Logger\async;

use Lyrica0954\Logger\webhook\Webhook;

use pocketmine\scheduler\Task;

class WebhookSendQueue extends Task{

    public static $instance = null;

    public static function getInstance(){
        return self::$instance;
    }

    public static function addQueue($instance){
        $st = self::getInstance();
        if ($instance instanceof Webhook){
            $st->logger->queue[] = $instance;
            return true;
        }
        return false;
    }

    public static function getQueue(){
        $st = self::getInstance();
        return $st->logger->queue;
    }

    public static function removeQueue($key){
        unset($this->logger->queue[$key]);
    }

    public static function removeAllQueue(){
        $this->logger->queue = array();
    }

    public static function stopSend(){
        $this->enable = false;
    }

    public static function startSend(){
        $this->enable = true;
    }

    public function __construct($parent){
        self::$instance = $this;
        $this->enable = true;
        $this->logger = $parent;
    }

    public function onRun(int $currentTick){
        if ($this->enable){
            if (count($this->logger->queue) > 0){
                $lastKey = array_key_last($this->logger->queue);
                $instance = $this->logger->queue[$lastKey];
                if ($instance instanceof Webhook){
                    $instance->sendWebhook(false);
                }
                unset($this->logger->queue[$lastKey]);
            }
        }
    }


}