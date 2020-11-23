<?php
session_start();
include_once 'object/Customer.php';

$user = new User();
$customerResult = $user->selectAllDefaulters();
// $areaResutl = $user->selectAllArea();


if (isset($_POST['searchCustomerForm'])) {
    $search = $_POST['search'];


    if ($user->searchDefaulterCustomer($search)) {
        $customerSearchResult = $user->searchDefaulterCustomer($search);
    } else {
        $_SESSION['resultNotFound'] = "No Result Found";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<?php include_once 'head.php' ?>
<style>
    #activeDefaulters {
        background-color: #6200EA;
        color: red !important;
    }
</style>

<body>
    <?php include_once 'header.php' ?>



    <form method="POST">
        <div class="input-group container w-25 justify-content-center mb-3 pt-3">

            <input type="text" name="search" class="form-control" placeholder="Search" aria-label="Recipient's username" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <input type="submit" class=" btn-primary  " name="searchCustomerForm" value="Search">

            </div>

        </div>
    </form>
    <div class="row justify-content-center ">
        <div class=" container col-auto">
            <table class="table   table-sm table-hover table-responsive">
                <thead>
                    <tr>
                        <th scope="col">CustomerID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Mobile Number</th>
                        <th scope="col">City</th>
                        <th scope="col">Area</th>
                        <th scope="col">Status</th>

                        <th scope="col">Payable</th>
                        <th scope="col">Paid</th>
                        <th scope="col ">Action</th>

                    </tr>
                </thead>
                <tbody>

                    <!-- Alert Messages goes here -->

                    <div style="text-align : center; margin-top:5px !important; width:50%; margin:auto;">
                        <span><?php if (isset($_SESSION['resultNotFound'])) {
                                    echo "<div class='alert alert-danger'>";
                                    echo  $_SESSION['resultNotFound'];
                                    echo "</div>";
                                    unset($_SESSION['resultNotFound']);
                                } ?> </span>
                    </div>

                    <?php if (!empty($customerResult)) { ?>
                        <?php foreach ($customerResult as $cusResult) { ?>

                            <?php
                            $customerDetailResult = $user->selectAllCustomerDetail($cusResult['Customer_ID']);
                            ?>

                            <tr>
                                <th scope="row"><?php echo $cusResult['Customer_ID'] ?></th>
                                <td><?php echo $cusResult['name'] ?></td>
                                <td><?php echo $cusResult['mobile'] ?></td>
                                <td><?php echo $cusResult['city'] ?></td>

                                <td><?php echo $cusResult['area'] ?></td>
                                <td><?php echo $cusResult['status'] ?></td>
                                <td><?php echo $cusResult['totalArrears'] ?></td>
                                <td><?php echo $cusResult['totalPaid'] ?></td>


                                <td><a type="button" class="btn btn-sm btn-primary" href="generateReportFront.php?customerReportID=<?php echo $cusResult['Customer_ID'] ?>&customerReportName=<?php echo $cusResult['name'] ?> ">Report</a></td>

                                <td><a type="button" class="btn btn-sm btn-danger" href="Edit.php?customerReportID=<?php echo $cusResult['Customer_ID'] ?>&customerReportName=<?php echo $cusResult['name'] ?> ">Edit</a></td>

                                <!-- <td><a type="button" class="btn btn-sm btn-success" href="EditCustomersFront.php?editCustomerName=<?php echo $cusResult['name'] ?> ">Pay Fees</a></td> -->

                            </tr>



                        <?php } ?>
                        <!-- Paging Link -->


                    <?php } else if (!empty($customerSearchResult)) { ?>

                        <?php foreach ($customerSearchResult as $cusResult) { ?>

                            <?php
                            $customerDetailResult = $user->selectAllCustomerDetail($cusResult['Customer_ID']);
                            ?>

                            <tr>
                                <th scope="row"><?php echo $cusResult['Customer_ID'] ?></th>
                                <td><?php echo $cusResult['name'] ?></td>
                                <td><?php echo $cusResult['mobile'] ?></td>
                                <td><?php echo $cusResult['city'] ?></td>

                                <td><?php echo $cusResult['area'] ?></td>
                                <td><?php echo $cusResult['status'] ?></td>
                                <td><?php echo $customerDetailResult['ArrearsSum'] ?></td>
                                <td><?php echo $customerDetailResult['FeeSum'] ?></td>


                                <td><a type="button" class="btn btn-sm btn-primary" href="generateReportFront.php?customerReportID=<?php echo $cusResult['Customer_ID'] ?>&customerReportName=<?php echo $cusResult['name'] ?> ">Report</a></td>

                                <td><a type="button" class="btn btn-sm btn-danger" href="Edit.php?customerReportID=<?php echo $cusResult['Customer_ID'] ?>&customerReportName=<?php echo $cusResult['name'] ?>  ">Edit</a></td>
                                <td><a type="button" class="btn btn-sm btn-success" href="EditCustomersFront.php?editCustomerName=<?php echo $cusResult['name'] ?> ">Pay Fees</a></td>

                            </tr>



                        <?php } ?>




                        <!-- end of Search Button  and start if else if -->
                    <?php } ?>
                    <!-- end of else if -->



                </tbody>
            </table>


            <?php include_once 'footer.php' ?>

</body>

</html>