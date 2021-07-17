<?php

declare(strict_types=1);

namespace Lyrica0954\Logger;

use pocketmine\plugin\PluginBase;

use Lyrica0954\Logger\webhook\Webhook;
use Lyrica0954\Logger\Log;
use Lyrica0954\Logger\async\WebhookSendQueue;

class Logger extends PluginBase{

    public static $instance = null;

    public static function getInstance(){
        return self::$instance;
    }

    public static function sendToDiscord($message, $url, $async = false, $username = "PMMP Logger"){
        $instance = new Webhook($message, $url, $username);
        return $instance->sendWebhook($async);

    }

    public static function createLog($content, $format = "Y/m/d H:i:s", $textFormat = "[%s] %s"){
        return new Log($content, $format, $textFormat);
    }

    public function onEnable(){
        self::$instance = $this;
        $this->queue = array();
        $this->getServer()->getLogger()->info("§a[Logger] §fLogger has been loaded!");

        $this->Task = new WebhookSendQueue($this);
        $this->getScheduler()->scheduleRepeatingTask($this->Task, 20);
    }


}
