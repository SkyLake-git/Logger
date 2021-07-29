<?php

declare(strict_types=1);

namespace Lyrica0954\Logger\discord;

class EmbedField{

    private $name;
    private $value;

    public function __construct(String $name, String $value){
        $this->name = $name;
        $this->value = $value;
    }

    public function getName(){
        return $this->name;
    }

    public function getValue(){
        return $this->value;
    }

    public function export(){
        return array("name"=>$this->name,"value"=>$this->value);
    }
}