<?php

declare(strict_types=1);

namespace Lyrica0954\Logger\event;

use pocketmine\event\Event;
use pocketmine\event\Cancellable;

class WebhookSendEvent extends Event implements Cancellable{

    private $webhook;

    public function __construct($webhook){
        $this->webhook = $webhook;
    }

    public function getWebhook(){
        return $this->webhook;
    }
}