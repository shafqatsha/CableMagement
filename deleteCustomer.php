<?php
session_start();

include_once 'object/Customer.php';

if (isset($_GET['customerReportID'])) {
    $user = new User();
    echo $_GET['customerReportID'];
    $user->deleteFromCustomer($_GET['customerReportID']);
    $user->deleteFromCustomerDetail($_GET['customerReportID']);
}
header('location:viewCustomersFront.php');
