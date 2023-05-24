<?php

# Used https://bcrypt-generator.com/ for getting the hashed passwords 
# Default passwords are 1234 or 4321

require_once "DBInit.php";

class HealthcareDB {

    public static function getEmailsPatients(){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT email FROM patients");
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function getEmailsDoctors(){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT email FROM doctors");
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function getDoctor($email) 
    {
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT * FROM doctors WHERE email = :email");
        $statement->bindParam(":email", $email);
        $statement->execute();
    
        return $statement->fetch(PDO::FETCH_ASSOC);
    }   

    public static function getPatient($email) 
    {
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT * FROM patients WHERE email = :email");
        $statement->bindParam(":email", $email);
        $statement->execute();
    
        return $statement->fetch(PDO::FETCH_ASSOC);
    }    

    public static function checkLoginPatient($email, $password){
        $db = DBInit::getInstance();

        $patient = self::getPatient($email);

        if ($patient){
            return password_verify($password, $patient['password']);
        }
        return false;  
    }

    public static function checkLoginDoctor($email, $password){
        $db = DBInit::getInstance();

        $doctor = self::getDoctor($email);

        if ($doctor){
            return password_verify($password, $doctor['password']);
        }
        return false;        
    }

    public static function isEmailUnique($email) {
        $db = DBInit::getInstance();

        $query = "SELECT COUNT(*) FROM patients WHERE email = :email";

        $statement = $db->prepare($query);
        $statement->bindParam(':email', $email);
        $statement->execute();
        $count = $statement->fetchColumn();
        return $count === 0;
    }

    public static function register($email, $password, $name, $last_name, $id, $phone, $birthday, $gender) {
        $db = DBInit::getInstance();
        
        $hash = password_hash($password, PASSWORD_DEFAULT);
    
        $statement = $db->prepare("INSERT INTO patients (email, password, name, last_name, id, phone, birthday, gender)
                                  VALUES (:email, :password, :name, :last_name, :id, :phone, :birthday, :gender)");
        
        $statement->bindParam(':email', $email);
        $statement->bindParam(':password', $hash);
        $statement->bindParam(':name', $name);
        $statement->bindParam(':last_name', $last_name);
        $statement->bindParam(':id', $id);
        $statement->bindParam(':phone', $phone);
        $statement->bindParam(':birthday', $birthday);
        $statement->bindParam(':gender', $genderFormatted);
        
        $statement->execute();
        
        return $statement;
    }   
    
    public static function checkPatientBookings($email){
        $db = DBInit::getInstance();

        $query = "  SELECT schedules.date, schedules.hour, appointments.id_appointment, doctors.name, doctors.last_name
                    FROM appointments
                    JOIN patients ON patients.id_patient = appointments.id_patient 
                    JOIN schedules ON schedules.id_schedule = appointments.id_schedule
                    JOIN doctors ON doctors.id_doctor = schedules.id_doctor
                    WHERE patients.email = :email
                    AND patients.id_patient = appointments.id_patient
                    AND appointments.id_schedule = schedules.id_schedule
                    AND doctors.id_doctor = schedules.id_doctor
                    ORDER BY schedules.date, schedules.hour";

        $statement = $db->prepare($query);
        $statement->bindParam(':email', $email);
        $statement->execute();

        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return $results;
    }

    public static function checkDoctorBookings($email){
        $db = DBInit::getInstance();

        $query = "  SELECT schedules.date, schedules.hour, appointments.id_appointment, patients.name, patients.last_name
                    FROM schedules
                    JOIN doctors ON doctors.id_doctor  = schedules.id_doctor  
                    JOIN appointments ON schedules.id_schedule = appointments.id_schedule
                    JOIN patients ON patients.id_patient = appointments.id_patient
                    WHERE doctors.email = :email
                    AND doctors.id_doctor  = schedules.id_doctor 
                    AND appointments.id_schedule = schedules.id_schedule
                    AND patients.id_patient = appointments.id_patient
                    ORDER BY schedules.date, schedules.hour";

        $statement = $db->prepare($query);
        $statement->bindParam(':email', $email);
        $statement->execute();

        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        //print_r($results);

        return $results;
    }

    public static function cancelBooking($id_appointment){
        $db = DBInit::getInstance();
    
        $query = "DELETE FROM appointments WHERE id_appointment = :id";
        $statement = $db->prepare($query);
        $statement->bindParam(':id', $id_appointment);
        $statement->execute();
    }

        
    public static function getSpecialities(){ //We only show the specialities we have doctors in.
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT DISTINCT speciality FROM doctors");
        $statement->execute();
    
        $specialities = $statement->fetchAll(PDO::FETCH_COLUMN);
    
        return $specialities;
    }

    public static function getDatesBySpeciality($speciality){
        $db = DBInit::getInstance();

        $statement = $db->prepare("
            SELECT DISTINCT schedules.date
            FROM schedules 
            INNER JOIN doctors ON doctors.id_doctor = schedules.id_doctor
            WHERE doctors.speciality = :speciality 
            AND schedules.state = 'Available'
            ORDER BY schedules.date, schedules.hour
        ");
        //order is temporal as I want to add a calendar
        $statement->bindParam(':speciality', $speciality);
        $statement->execute();

        $dates = $statement->fetchAll(PDO::FETCH_COLUMN);

        return $dates;
    }

    public static function getDoctorsByDateAndSpeciality($speciality, $date, $id_patient){
        $db = DBInit::getInstance();

        //In the future we should change the sql statement as we need to avoid to have two appointments
        // at the same moment for the same patient. I've tried but I didn't correct it fully
        $statement = $db->prepare("
            SELECT DISTINCT doctors.id_doctor, doctors.name, doctors.last_name, schedules.hour
            FROM schedules
            INNER JOIN doctors ON doctors.id_doctor = schedules.id_doctor
            WHERE doctors.speciality = :speciality
            AND schedules.date = :date
            AND schedules.state = 'AVAILABLE'
        ");
        $statement->bindParam(':speciality', $speciality);
        $statement->bindParam(':date', $date);
        $statement->execute();
    
        $doctors = $statement->fetchAll(PDO::FETCH_ASSOC);

        //print_r($doctors);
    
        return $doctors;
    } 
    
    public static function bookAppointment($id_doctor, $hour, $date, $id_patient) {
        $db = DBInit::getInstance();
    
        // Get id_schedule with the other data

        $statement = $db->prepare("
            SELECT id_schedule
            FROM schedules
            WHERE id_doctor = :id_doctor
            AND date = :date
            AND hour = :hour
        ");
        $statement->bindParam(':id_doctor', $id_doctor);
        $statement->bindParam(':date', $date);
        $statement->bindParam(':hour', $hour);
        $statement->execute();
        
        $id_schedule = $statement->fetchColumn();

        if ($id_schedule) {
            // Insert into appointments
            $statement = $db->prepare("
                INSERT INTO appointments (id_patient, id_schedule)
                VALUES (:id_patient, :id_schedule)
            ");
            $statement->bindParam(':id_patient', $id_patient);
            $statement->bindParam(':id_schedule', $id_schedule);
            $result = $statement->execute();
    
            return $result;
        } else {
            // We couldn't find the id_schedule
            return false;
        }
    }    
}
?>