<?php

require_once("controller/HealthcareController.php");

# Define a global constant pointing to the URL of the application
define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");

# Request path after /index.php/ with leading and trailing slashes removed
$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

# The mapping of URLs. It is a simple array where:
# - keys represent URLs
# - values represent functions to be called when a client requests that URL
$urls = [
    "main" => function () {
        HealthcareController::main();
    },

    "healthcare/login_patient" => function () {
        HealthcareController::loginPatient();
    },

    "healthcare/login_doctor" => function () {
        HealthcareController:: loginDoctor();
    },

    "healthcare/logout" => function () {
        HealthcareController:: logout();
    },

    "healthcare/register" => function () { //only patients can be registered with the form.
        HealthcareController::registerPatient();
    },

    "healthcare/profile_patient" => function () {
        HealthcareController::profilePatient();    
    },

    "healthcare/profile_doctor" => function () {
        HealthcareController::profileDoctor();    
    },

    "healthcare/my_bookings" => function () {
        HealthcareController::checkBookings();
    },

    "healthcare/cancel_booking" => function () {
        if(isset($_POST["id_appointment"]))
            HealthcareController::cancelBooking($_POST["id_appointment"]);
    },

    "healthcare/contact" => function () {
        HealthcareController::contact();
    },

    "healthcare/about_us" => function () {
        HealthcareController::aboutUs();
    },

    "healthcare/book" => function () {
        HealthcareController::book();
    },

    #default
    "" => function () {
        ViewHelper::redirect(BASE_URL . "main");
    }
];

# The actual router.
# Tries to invoke the function that is mapped for the given path
try {
    if (isset($urls[$path])) {
        # Great, the path is defined in the router
        $urls[$path](); // invokes function that calls the controller
    } else {
        # Fail, the path is not defined. Show an error message.
        echo "No controller for '$path'";
    }
} catch (Exception $e) {
    # Provisional: whenever there is an exception, display some info about it
    # this should be disabled in production
    ViewHelper::error400($e);
} finally {
    exit();
}
