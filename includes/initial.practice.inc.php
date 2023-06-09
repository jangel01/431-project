<?php

session_start();
$userId = $_SESSION['user_id'];
$userType = $_SESSION['user_type'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include "../classes/dbh.classes.php";
    include "../classes/user.details.classes.php";
    include "../classes/user.details.contr.classes.php";

    // check if the user selected something from the dropdown and it is not empty
    if (isset($_POST['practice_name_select']) && $_POST['practice_name_select'] != "empty" && $userId && $userType == "medical_professional") {
        // grab the relevant data from the form
        $practice_name = $_POST['practice_name_select'];

        include "../classes/practice.classes.php";
        include "../classes/practice.contr.classes.php";

        $initPractice = new PracticeContr($practice_name, $userId);

        // associate practice with user
        $initPractice->associatePracticeContr();

        // set medical practice exist to true
        $currentUser = new UserDetailsContr($userType, $userId, null, null, null, null, null, null, null, null);
        $currentUser->setPracticeExistBoolContr(1);

        // redirect to next page
        header("location: ../initial-preferences.php");
    } else {
        if ($userId && $userType == "medical_professional") {
            // grab the relevant data from the form
            $practice_name = $_POST['practice_name'];
            $practice_type = $_POST['practice_type'];
            $practice_specialty = $_POST['practice_specialty'];
            $practice_email = $_POST['practice_email'];
            $practice_address = $_POST['practice_address'];
            $practice_phone = $_POST['practice_phone'];

            include "../classes/practice.classes.php";
            include "../classes/practice.contr.classes.php";

            $initPractice = new PracticeContr($practice_name, $userId, $practice_type, $practice_specialty, $practice_email, $practice_address, $practice_phone);

            // add new practice
            $initPractice->addNewPracticeContr();

            // associate practice with user
            $initPractice->associatePracticeContr();

            // set medical practice exist to true
            $currentUser = new UserDetailsContr($userType, $userId, null, null, null, null, null, null, null, null);
            $currentUser->setPracticeExistBoolContr(1);

            // redirect to next page
            header("location: ../initial-preferences.php");
        }
    }
}
