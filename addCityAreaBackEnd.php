

<?php

include_once 'object/Customer.php';

if (isset($_POST['cityForm'])) {
    $user =  new User();
    $city = $_POST['addCity'];
    $user->addCity($city);
} else if (isset($_POST['areaForm'])) {

    $user =  new User();
    $area = $_POST['addArea'];
    $user->addArea($area);
}

header('location:addCityAreaFront.php');

?>