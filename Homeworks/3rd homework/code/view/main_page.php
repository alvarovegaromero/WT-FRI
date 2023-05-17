<!DOCTYPE html>

<meta charset="UTF-8" />
<title> Main Page </title>

<h1> Main Page </h1>

<?php

    print(password_hash(1234, PASSWORD_DEFAULT) . " hola \n");
    print("\n");
    print(password_hash(4321, PASSWORD_DEFAULT) . " hola2 \n");
    //print(password_hash($usuario['password'], PASSWORD_DEFAULT));

?>