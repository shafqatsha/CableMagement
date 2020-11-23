
<?php
session_start();
include_once 'object/Customer.php';
if (isset($_POST["customerForm"])) {



    // Create customer

    $user = new User();


    $user->mobileNo = $_POST['mobileNumber'];
    $user->customerName = $_POST['customerName'];

    $user->area = $_POST['area'];

    $user->city = $_POST['city'];
    $user->status = $_POST['status'];
    $user->conn_date = $_POST['con_date'];
    $user->paid_date = $_POST['paidDate'];
    $user->fee_paid = $_POST['paidFee'];
    $user->totalFee = $_POST['totalFee'];

    if (empty($_POST['paidFee'])) {
        $user->arrears = $user->totalFee - $user->fee_paid;
    } else {
        $user->arrears = $user->totalFee - $user->fee_paid;
    }

    $customerID = $_POST['customerID'];
    if (
        $user->updateCustomer($customerID) &&

        $user->insertIntoCustomerDetails($customerID)
    ) {

        $_SESSION['DataUpdate'] = 'Updated';
    }
    header('location:editCustomersFront.php');
}

// else if (isset($_POST["seacrhForm"])) {




//     function CustomerSearch()

//     {
//         $user = new User();


//         $searchQ = $_POST['searchCustomer'];

//         $resultCustomer = $user->search($searchQ);

//         return $resultCustomer;
//     }

//     header('location:editCustomersFront.php');
// }



?>