<?php

require_once ("BookDB.php");

?><!DOCTYPE html>
<meta charset="UTF-8" />
<title>Book detail</title>

<?php $book = BookDB::get($_GET["id"]); ?>

<div style="display: inline-block; border: 1px solid blue;"> 
    <h1>Details about: <?= $book->getTitle() ?></h1>

    <!-- TODO: provide details about the book -->

    <ol>
        <li>Author: <?= $book->getAuthor() ?></li>
        <li>Price: <?= $book->getPrice() ?></li>
    </ol>
<div>