<?php

declare(strict_types=1);

namespace Lyrica0954\Logger\async;

use Lyrica0954\Logger\webhook\Webhook;
use Lyrica0954\Logger\webhook\WebhookResponse;

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
        $st = self::getInstance();
        unset($st->logger->queue[$key]);
    }

    public static function removeAllQueue(){
        $st = self::getInstance();
        $st->logger->queue = array();
    }

    public static function stopSend(){
        $st = self::getInstance();
        $st->enable = false;
    }

    public static function startSend(){
        $st = self::getInstance();
        $st->enable = true;
    }

    public function __construct($parent){
        self::$instance = $this;
        $this->enable = true;
        $this->nextEnable = 0;
        $this->logger = $parent;
    }

    public function onRun(int $currentTick){
        if ($this->enable){
            if (count($this->logger->queue) > 0){
                $lastKey = array_key_last($this->logger->queue);
                $instance = $this->logger->queue[$lastKey];
                if ($instance instanceof Webhook){
                    $returns = $instance->sendWebhook(false);
                    if ($returns instanceof WebhookResponse){
                        if (!$returns->success()){
                            $returns->setText($returns->getText() . "retry in 15 seconds...");
                            $returns->log();
                            $this->enable = false;
                            $this->nextEnable = 15;
                            return;
                        }
                    }

                }
                unset($this->logger->queue[$lastKey]);
            }
        } else {
            if ($this->nextEnable > 0){
                $this->nextEnable --;
            } else {
                $this->enable = true;
                $this->nextEnable = 0;
            }
        }
    }


}