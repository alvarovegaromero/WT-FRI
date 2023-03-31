<?php

class Book {
    public $title = null;
    public $author = null;
    public $id = 0;

    /**
     * Constructor: creates a new instance.
     * @param type $id
     * @param type $title
     * @param type $author
     * @param type $price
     */
    public function __construct($id, $title, $author, $price) {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->price = $price;
    }

    /**
     * A string representation
     * @return type String
     */
    public function __toString() {
        return sprintf("%s: %s - %d€", $this->author, $this->title, $this->price);
    }

    public function getId(){
        return $this->id;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getPrice(){
        return $this->price;
    }

    public function getAuthor(){
        return $this->author;
    }
}