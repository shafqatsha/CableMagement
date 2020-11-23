
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

    $user->mobileNo = $_POST['mobileNumber'];

    if ($user->mobileExists()) {
        // alert code here
        $_SESSION['userWithMobileAlreadyExists'] = "User with same mobile number already exists ";
    } else {

        $user->customerName = $_POST['customerName'];
        $user->mobileNo = $_POST['mobileNumber'];
        $user->mobileNO2 = $_POST['mobileNumber2'];
        if ($_POST['area'] != "areaNotInTheList") {
            $user->area = $_POST['area'];
        } else {
            $user->area = $_POST['notInTheList'];
        }
        $user->city = $_POST['city'];
        $user->status = $_POST['status'];
        $user->conn_date = $_POST['con_date'];
        $user->paid_date = $_POST['con_date'];

        if ($_POST['area'] == "areaNotInTheList" && empty($_POST['notInTheList'])) {
            $_SESSION['AreaError'] = "Please Select Area";
        } else {



            if ($user->create()) {
                $_SESSION['RecordCreated'] = "Success";
                // INSERT Record into customer Detail Table
                $user->addArea($user->area);
                // add area into area Table
                $customer_id = $user->getLastInsertedResult();
                if (!empty($customer_id)) {
                    foreach ($customer_id as $ID) {
                        $cid = $ID['Customer_ID'];
                    }
                }
                $user->fee_paid = $_POST['recivedPayment'];
                $user->totalFee = $_POST['totalPayment'];
                if (empty($_POST['recivedPayment'])) {
                    $user->arrears = $user->totalFee - $user->fee_paid;
                } else {
                    $user->arrears = $user->totalFee - $user->fee_paid;
                }

                $user->insertIntoCustomerDetails($cid);
            } else {
                $_SESSION['RecordFailed'] = "There is some error Please Check";
            }
        }
        // End of outer if
    }
}

header('location:addCustomersFront.php');

?>