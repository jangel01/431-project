<?php

session_start();
$userId = $_SESSION['user_id'];
$userType = $_SESSION['user_type'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include "../classes/dbh.classes.php";
    include "../classes/preferences.classes.php";
    include "../classes/preferences.contr.classes.php";

    if (isset($_POST['availability'])) {
        $availability = $_POST['availability'];
        $availability = implode(", ", $availability);

        $initPreferences = new PreferencesContr($userId, $userType, $availability);

        // set availability preferences
        $initPreferences->setAvailabilityPreferencesContr();

        // redirect to next page
        header("location: ../homepage.php");
    } else {
        $availability = "None";
        $initPreferences = new PreferencesContr($userId, $userType, $availability);

        // set availability preferences
        $initPreferences->setAvailabilityPreferencesContr();
    }

    if (isset($_POST['food'])) {
        $food = $_POST['food'];
        $food = implode(", ", $food);

        $initPreferences = new PreferencesContr($userId, $userType, null, $food);

        // set food preferences
        $initPreferences->setFoodPreferencesContr();
    } else {
        $food = "None";
        $initPreferences = new PreferencesContr($userId, $userType, null, $food);

        // set food preferences
        $initPreferences->setFoodPreferencesContr();
    }

    // redirect to next page
    header("location: ../user-details.php?user_type=$userType&user_id=$userId");
}