<?php

#require_once("model/HealthcareDB.php");
require_once("ViewHelper.php");

# Controller for handling books
class HealthcareController {

    public static function main(){
        $variables = array();
        ViewHelper::render("view/main_page.php", $variables);
    }
}