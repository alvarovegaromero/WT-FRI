<!DOCTYPE html>

<meta charset="UTF-8" />
<title>Answering the prime question</title>

<?php

// Complete function isPrime($number) by implementing a simple algorithm
function isPrime($number) {
    if ($number <= 1) { 
        return false;
    }

    for ($i = 2; $i <= sqrt($number); $i++) { //we check if it's divisible by one prime number
        if ($number % $i == 0) {
            return false;
        }
    }

    return true;
}

$number = $_GET["number"];

?>

<h1>Checking if <?=$number?> is prime</h1>

<p><?php

if (isPrime($number)) {
    echo "Yes, $number is a prime number.";
} else {
    echo "No, $number is not prime.";
}

?></p>
