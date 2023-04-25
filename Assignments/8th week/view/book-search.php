<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Search books</title>
</head>
<body>

<h1>Search for books</h1>

<form action="<?php echo BASE_URL ?>book/search" method="get">
    <label for="query">Search books:</label>
    <input type="text" name="query" id="query" />
    <button type="submit">Search</button>
</form>

<?php if(!empty($variables)): ?>
    <ul>
        <?php foreach ($variables as $book): ?>
            <li> <a href="<?= BASE_URL ?>book?id=<?= $book["id"] ?>"> <?= $book["author"] ?>: <?= $book["title"] ?> - <?= $book["year"] ?> </a></li>
        <?php endforeach; ?>
    </ul>

<?php endif; ?>