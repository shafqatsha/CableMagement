<?php

if (isset($_GET['sort']) && $_GET['sort'] == 'ASC') {
    $sort = 'DESC';
} else {
    $sort = 'ASC';
}

$user = new User();

$user->sortByPayable($sort);


// header('location:viewCustomersFront.php');
