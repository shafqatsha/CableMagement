
<?php
session_start();
if ($_POST) {
    include_once 'config/database.php';
    include_once 'object/Customer.php';
    // Connect Databace
    $database = new Database();
    $db = $database->getConnection();

    // Create customer

    $user = new User();

    $searchQuery = $_POST['searchCustomer'];

    $user->search($searchQuery);
}

// header('location:addCustomersFront.php');

?>