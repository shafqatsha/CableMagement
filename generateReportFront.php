<?php

include_once 'object/Customer.php';

if (isset($_POST["generateReportForm"])) {



    // Create customer

    $user = new User();
    if (isset($_GET['customerReportID'])) {
        $customerID = $_GET['customerReportID'];
    }
    // = $_POST['customerID'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    $customerDetailResult =    $user->generateReport($startDate, $endDate, $customerID);

    $customerResult =  $user->searchCustomerByID($customerID);
} else if (isset($_POST['generateReportYearForm'])) {

    $user = new User();
    if (isset($_GET['customerReportID'])) {
        $customerID = $_GET['customerReportID'];
    }
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];


    $customerYearlyDetailResult =    $user->generateYearlyReport($startDate, $endDate, $customerID);

    $customerResult =  $user->searchCustomerByID($customerID);

    // $yearlySum = $user->yearlySum();
}
?>

<!DOCTYPE html>
<html lang="en">

<?php include_once 'head.php' ?>

<body>
    <?php include_once 'header.php' ?>

    <?php
    $user = new User();
    $allCustomers = $user->selectAllCustomer();
    ?>

    <form method="POST">
        <!-- <input type="hidden" value="<?php ?>">
        <div class="d-flex justify-content-center  pt-2">
            <input list="browsers" class="w-25" name="getReport" id="browser">
            <datalist id="browsers">

                <?php if (!empty($allCustomers)) { ?>
                    <?php foreach ($allCustomers as $customer) { ?>
                        <option value="<?php echo $customer['name'] ?>">
                        <?php } ?>
                    <?php } ?>

            </datalist>
            <input type="submit" name="generateReportForm" class=" btn btn-primary" value="Generate Report">
        </div> -->
        <div class="d-flex justify-content-center   pt-2">
            <input type="text" class="w-25 text-center" name="name" value="<?php if (isset($_GET['customerReportName'])) {
                                                                                echo $_GET['customerReportName'];
                                                                            } ?>" disabled>
        </div>
        <input type="hidden" name="customerID" value="">
        <div class="d-flex justify-content-around ">

            <!-- Some Php Code to fetch Connection Date of given person from customers Table -->

            <?php

            $user = new User();

            if (isset($_GET['customerReportID'])) {
                $customerID = $_GET['customerReportID'];
            }
            $customerResult =  $user->searchCustomerByID($customerID);
            if (!empty($customerResult)) {
                foreach ($customerResult as $cusResult) {
                    $defautlConValue =  $cusResult['connection_date'];
                }
            }

            ?>
            <!-- Code END -->
            <div class="form-group">
                <label for="Start Date">Start Date</label>
                <input type="date" class="form-control" name="startDate" id="" value="<?php echo $defautlConValue ?>" aria-describedby="helpId" placeholder="" required>

            </div>
            <div class="form-group">
                <label for="Start Date">End Date</label>

                <input type="date" class="form-control" name="endDate" id="" aria-describedby="helpId" placeholder="" required>

            </div>



        </div>
        <!-- Year Selection Date -->
        <!-- <div class="d-flex justify-content-around ">



            <div class="form-group">
                <label for="Start Date">Start Year</label>
                <input type="date" class="form-control" name="startYearDate" id="" aria-describedby="helpId" placeholder="" required>

            </div>
            <div class="form-group">
                <label for="Start Date">End Year</label>
                <input type="date" class="form-control" name="endYearDate" id="" aria-describedby="helpId" placeholder="" required>

            </div>



        </div> -->
        <div class="d-flex justify-content-center ">
            <div class="pr-1">

                <input type="submit" name="generateReportForm" class=" btn btn-primary" value="Generate Report">
            </div>
            <div class="pl-1">
                <input type="submit" name="generateReportYearForm" class=" btn btn-primary" value="Yearly Report">
            </div>

        </div>

    </form>
    <div class="row">
        <div class="container  pt-3">
            <table class="table table-striped text-center table-sm ">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Fee Paid</th>
                        <th>Fee Payable</th>
                        <th>Arrears</th>
                        <th>For The Month</th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (!empty($customerDetailResult)) { ?>
                        <?php foreach ($customerDetailResult as $cusDetailResult) { ?>
                            <tr>

                                <?php if (!empty($customerResult)) { ?>
                                    <?php foreach ($customerResult as $cusResult) { ?>
                                        <td scope="row"><?php echo $cusResult['Customer_ID'] ?></td>
                                        <td><?php echo $cusResult['name'] ?></td>


                                        <td><?php echo $cusResult['mobile'] ?></td>
                                    <?php } ?>
                                <?php } ?>

                                <td><?php echo $cusDetailResult['fee_paid'] ?></td>
                                <td></td>
                                <td><?php echo $cusDetailResult['arrears'] ?></td>
                                <td><?php echo $cusDetailResult['paid_date'] ?></td>


                            </tr>
                        <?php } ?>
                    <?php } else if (!empty($customerYearlyDetailResult)) { ?>
                        <?php foreach ($customerYearlyDetailResult as $cusDetailResult) { ?>



                            <tr>

                                <?php if (!empty($customerResult)) { ?>
                                    <?php foreach ($customerResult as $cusResult) { ?>
                                        <td scope="row"><?php echo $cusResult['Customer_ID'] ?></td>
                                        <td><?php echo $cusResult['name'] ?></td>


                                        <td><?php echo $cusResult['mobile'] ?></td>
                                    <?php } ?>
                                <?php } ?>




                                <td><?php echo $cusDetailResult['feeSum'] ?></td>
                                <td></td>
                                <td><?php echo $cusDetailResult['arrearsSum'] ?></td>
                                <td><?php echo $cusDetailResult['paid_date'] ?></td>


                            </tr>
                        <?php } ?>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
    <?php include_once 'footer.php' ?>

</body>

</html>