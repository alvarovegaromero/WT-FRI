<?php

require_once("model/HealthcareDB.php");
require_once("ViewHelper.php");

# Controller for handling books
class HealthcareController {

    public static function main(){
        session_start(); //resume session if exists

        if(isset($_SESSION['patient'])){
            $variables = ["patient" =>$_SESSION['patient']];
            ViewHelper::render("view/main_page.php", $variables);
        }
        else if(isset($_SESSION['doctor'])){
            $variables = ["doctor" =>$_SESSION['doctor']];
            ViewHelper::render("view/main_page.php", $variables);
        }
        else
            ViewHelper::render("view/main_page.php");
    }

    public static function loginPatient(){

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $validData =    isset($_POST["email"]) && !empty($_POST["email"]) && 
                            isset($_POST["password"]) && !empty($_POST["password"]);

            if($validData && HealthcareDB::checkLoginPatient($_POST["email"], $_POST["password"])){
                session_start();
                $_SESSION['patient'] = HealthcareDB::getPatient($_POST["email"]);

                ViewHelper::redirect(BASE_URL . "main");
            }
        }
        ViewHelper::render("view/login_patient.php");
    }

    public static function loginDoctor(){ //Maybe in future version is more different than from patients'
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $validData =    isset($_POST["email"]) && !empty($_POST["email"]) && 
                            isset($_POST["password"]) && !empty($_POST["password"]);

            if($validData && HealthcareDB::checkLoginDoctor($_POST["email"], $_POST["password"])){
                session_start();
                $_SESSION['doctor'] = HealthcareDB::getDoctor($_POST["email"]);
                
                ViewHelper::redirect(BASE_URL . "main");
            }
        }
        ViewHelper::render("view/login_doctor.php");
    }

    public static function logout(){
        session_start();
        session_destroy();
        session_write_close(); // We asure that the session has been destroyed
    
        ViewHelper::redirect(BASE_URL . "main");
    }

    
    public static function registerPatient(){
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $validData =    isset($_POST["email"]) && !empty($_POST["email"]) && 
                            isset($_POST["password"]) && !empty($_POST["password"]) &&
                            isset($_POST["name"]) && !empty($_POST["name"]) &&
                            isset($_POST["last_name"]) && !empty($_POST["last_name"]) &&
                            isset($_POST["id"]) && !empty($_POST["id"]) &&
                            isset($_POST["phone"]) && !empty($_POST["phone"]) &&
                            isset($_POST["birthday"]) && !empty($_POST["birthday"]) &&
                            isset($_POST["gender"]) && !empty($_POST["gender"]);
            
            if( $validData && 
                HealthcareDB::register($_POST["email"], $_POST["password"], $_POST["name"], $_POST["last_name"], 
                                       $_POST["id"], $_POST["phone"], $_POST["birthday"], $_POST["gender"])){
                session_start();
                $_SESSION['patient'] = HealthcareDB::getPatient($_POST["email"]);
                
                ViewHelper::redirect(BASE_URL . "main");
            }
        }

        ViewHelper::render("view/register.php");
    }

    public static function profilePatient(){ //Maybe in a future version they do more different things than with doctors
        session_start();

        $variables = ["patient" =>$_SESSION['patient']];
        
        ViewHelper::render("view/profile_patient.php", $variables);
    }

    public static function profileDoctor(){
        session_start();

        $variables = ["doctor" =>$_SESSION['doctor']];
        
        ViewHelper::render("view/profile_doctor.php", $variables);
    }

    /*
    public static function checkPatientBookings(){
        session_start();

        $variables = [  "appointments" => HealthcareDB::checkPatientBookings($_SESSION['patient']["email"]), 
                        "patient" => $_SESSION['patient']];

        ViewHelper::render("view/my_bookings.php", $variables);  
    }

    public static function checkDoctorBookings(){
        session_start();

        $variables = [  "appointments" => HealthcareDB::checkDoctorBookings($_SESSION['doctor']["email"]), 
                        "doctor" => $_SESSION['doctor']];

        ViewHelper::render("view/my_bookings.php", $variables);  
    }*/

    public static function checkBookings(){ //Example of unified version. I expect in the future, probably they will 
                                            // not do the same things, so it would be better in different methods
                                            // but as an example if fine
        session_start();

        if(isset($_SESSION['patient'])){
            $variables = [  "appointments" => HealthcareDB::checkPatientBookings($_SESSION['patient']["email"]), 
                            "patient" => $_SESSION['patient']];
        }
        else if(isset($_SESSION['doctor'])){
            $variables = [  "appointments" => HealthcareDB::checkDoctorBookings($_SESSION['doctor']["email"]), 
                            "doctor" => $_SESSION['doctor']];
        }

        ViewHelper::render("view/my_bookings.php", $variables);  
    }

    public static function cancelBooking($id_appointment){
        HealthcareDB::cancelBooking($id_appointment);
        
        self::checkBookings();
    }  

    public static function book() {
        session_start();
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if(isset($_POST["speciality"]) && isset($_POST["date"]) && isset($_POST["id_doctor_and_hour"])){
                $selectedOption = $_POST["id_doctor_and_hour"];
                list($id_doctor, $hour) = explode('|', $selectedOption);
                
                //print($_SESSION['patient']['email']);
                HealthcareDB::bookAppointment($id_doctor, $hour, $_POST["date"], $_SESSION['patient']['id_patient']);

                //self::checkBookings();
                ViewHelper::redirect(BASE_URL . "healthcare/my_bookings");
            }
            else if(isset($_POST["speciality"]) && isset($_POST["date"])){
                $variables = [  "speciality" => $_POST["speciality"],
                                "date" => $_POST["date"],
                                "doctors" => HealthcareDB::getDoctorsByDateAndSpeciality(
                                            $_POST["speciality"], $_POST["date"], $_SESSION['patient']['id_patient'])];

                ViewHelper::render("view/book.php", $variables);    
            }
            else if(isset($_POST["speciality"])){ //else if for security
                
                /*$dates = HealthcareDB::getDatesBySpeciality($_POST["speciality"]);
                foreach ($dates as $date) 
                    echo $date . "<br>";*/
                
                $variables = [  "speciality" => $_POST["speciality"],
                                "dates" => HealthcareDB::getDatesBySpeciality($_POST["speciality"])];

                ViewHelper::render("view/book.php", $variables);    
            }
        } else {
            //print_r($specialties);

            $variables = ["specialities" => HealthcareDB::getSpecialities()];
            ViewHelper::render("view/book.php", $variables);  
        }
    }

    public static function contact(){
        ViewHelper::render("view/contact.php");  
    }

    public static function aboutUs(){
        ViewHelper::render("view/about_us.php");  
    }
}