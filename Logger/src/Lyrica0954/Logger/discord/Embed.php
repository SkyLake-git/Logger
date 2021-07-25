<?php

declare(strict_types=1);

namespace Lyrica0954\Logger\discord;

use Lyrica0954\Logger\discord\EmbedField;

class Embed{

    private $title;
    private $description;
    private $color;
    private $author;
    private $fields = array();

    public function __construct(String $description, String $title = "", String $author = "PMMP Logger", Int $color = null, Array $fields = array()){
        $this->description = $description;
        $this->title = $title;
        $this->author = $author;
        $this->color = $color;
        $this->fields = $fields;
    }

    public function getTitle(){
        return $this->title;
    }
    
    public function getDescription(){
        return $this->desciption;
    }

    public function getColor(){
        return $this->color;
    }

    public function getAuthor(){
        return $this->author;
    }

    public function getFields(){
        return $this->fields;
    }

    public function setFields(Array $fields){
        $this->fields = $fields;
    }

    public function addField(EmbedField $field){
        $this->fields[] = $field;
    }

    public function hasField(){
        return count($this->fields) >= 1;
    }

    public function export(){
        $json = array(
            "title"=>$this->title,
            "description"=>$this->description,
            "color"=>$this->color,
            "author"=>array(
                "name"=>$this->author
            ),
            "fields"=>array(

            )
        );

        foreach($this->fields as $field){
            if ($field instanceof EmbedField){
                $json["fields"][] = $field->export();
            }
        }

        return $json;
    }
}