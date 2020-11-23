
<?php
session_start();
include_once 'object/Customer.php';
if (isset($_POST["customerForm"])) {



    // Create customer

    $user = new User();

    $customerID = $_POST['customerID'];
    $user->mobileNo = $_POST['mobileNumber'];
    // number2
    $user->mobileNO2 = $_POST['mobileNumber2'];
    $user->customerName = $_POST['customerName'];

    $user->area = $_POST['area'];

    $user->city = $_POST['city'];
    $user->status = $_POST['status'];
    $user->conn_date = $_POST['connDate'];


    if ($user->updateCustomer($customerID)) {
        $_SESSION['Alert_Update'] = " SUCCESS ";
    } else {
        $_SESSION['Alert_Update'] = " Some Thing Went Wrong ";
    }
    header('location:Edit.php');
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