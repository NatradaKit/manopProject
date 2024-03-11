<?php
include('user.php');

class Student extends User {
    private $studentId;

    // Constructor
    public function __construct($username, $email, $password, $role, $contact, $studentId) {
        parent::__construct($username, $email, $password, $role, $contact);
        $this->studentId = $studentId;
    }

    // Getter methods
    public function getStudentId() {
        return $this->studentId;
    }


    // Setter methods
    public function setStudentId($studentId) {
        $this->studentId = $studentId;
    }

    // Override method showObjectData
    public function showObjectData(){
        parent::showObjectData();
        echo "Student ID: " . $this->getStudentId() . "<br>";
    }
}
