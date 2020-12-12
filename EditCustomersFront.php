<?php
session_start();
include_once 'object/Customer.php';

?>

<!DOCTYPE html>
<html lang="en">

<?php include_once 'head.php' ?>
<style>
    #activeEditCustomers {
        background-color: #6200EA;
    }
</style>

<body>
    <?php include_once 'header.php' ?>


    <?php
    $user = new User();
    $allCustomers = $user->selectAllCustomer();
    ?>

    <div class="row">
        <div class="container pt-4 ">
            <form method="POST">
                <div class="input-group input-group-sm mb-3 w-25 m-auto  ">

                    <input list="browsers" name="searchCustomer" id="browser" value="<?php if (isset($_GET['editCustomerName'])) echo $_GET['editCustomerName']; ?> " autocomplete="off">
                    <datalist id="browsers">


                        <?php if (!empty($allCustomers)) { ?>
                            <?php foreach ($allCustomers as $customer) { ?>
                                <option value="<?php echo $customer['name'] ?>">
                                <?php } ?>
                            <?php } ?>

                    </datalist>
                    <input type="submit" class="bg-primary text-white" name="seacrhForm" value="search">
                </div>

            </form>

        </div>
    </div>
    <div class="row">
        <div class="container pt-4 w-75">

            <!-- some php code -->

            <?php

            if ($_POST) {

                $user = new User();

                $searchQuery = htmlspecialchars(strip_tags($_POST['searchCustomer']));

                $customerEditResult =  $user->search($searchQuery);




                if (!empty($customerEditResult)) {
                    foreach ($customerEditResult as $result) {
                        $totalPayable = $user->totalArrears($result['Customer_ID']);
                    }
                }
            }



            ?>

            <!-- some php code end -->
            <form method="POST" action="editCustomerUpdateData.php">

                <!-- Alert Messages -->
                <div style="text-align : center; margin-top:20px !important; width:40%; margin:auto;">
                    <span><?php if (isset($_SESSION['DataUpdate'])) {
                                echo "<div class='alert alert-success'>";
                                echo  $_SESSION['DataUpdate'];
                                echo "</div>";
                                unset($_SESSION['DataUpdate']);
                            } ?> </span>
                </div>
                <!-- Alert Messages End -->
                <!-- start of if  -->
                <?php if (empty($customerEditResult)) { ?>
                    <div class=" alert alert-danger w-25 m-auto ">
                        <span>Record Not Found</span>
                    </div>
                    <?php  } else {
                    foreach ($customerEditResult as $result) { ?>

                        <input type="hidden" name="customerID" value="<?php echo $result['Customer_ID']; ?>" />
                        <div class=" form-row">
                            <div class="form-group col-md-5">
                                <label for="inputEmail4">Customer Name</label>
                                <input type="text" name="customerName" class="form-control" value="<?php echo $result['name'] ?>" id="inputEmail4" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Mobile Number</label>
                                <input type="number" name="mobileNumber" value="<?php echo $result['mobile'] ?>" class="form-control" id="inputPassword4" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputAddress2">Connection Date</label>
                                <input type="date" name="con_date" value="<?php echo $result['connection_date'] ?>" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="inputEmail4">Monthly Fee</label>
                                <input type="number" name="totalFee" class="form-control" id="inputEmail4" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Paid</label>
                                <input type="number" name="paidFee" class="form-control" id="inputPassword4" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputPassword4">Arrears</label>
                                <input type="number" name="arrears" value="<?php echo $totalPayable['arrears'] ?>" class="form-control" id="inputPassword4" disabled>
                            </div>
                        </div>

                        <div class=" form-row ">

                            <div class="form-group col-md-6">
                                <label for="inputAddress2">Fees Updated</label>
                                <input type="date" name="paidDate" class="form-control" id="inputAddress2" required>
                            </div>


                            <!-- fetching city form table -->
                            <?php
                            $user = new User();
                            $cityResutl = $user->selectAllCity();
                            $areaResutl = $user->selectAllArea();

                            ?>
                            <div class="form-group col-md-6">

                                <label for="inputCity">City</label>
                                <select id="inputCity" name="city" class="form-control">
                                    <option value="<?php echo $result['city'] ?>" selected><?php echo $result['city'] ?></option>

                                    <?php if (!empty($cityResutl)) { ?>
                                        <?php foreach ($cityResutl as $cresult) { ?>
                                            <option value="<?php echo $cresult['cityName'] ?>"><?php echo $cresult['cityName'] ?></option>
                                        <?php } ?>
                                    <?php } ?>

                                </select>

                            </div>

                        </div>


                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label for="inputState">Area</label>
                                <select id="inputState" name="area" class="form-control" required>
                                    <option value="<?php echo $result['area'] ?>" selected><?php echo $result['area'] ?></option>

                                    <?php if (!empty($areaResutl)) { ?>
                                        <?php foreach ($areaResutl as $aResult) { ?>
                                            <option value="<?php echo $aResult['areaName'] ?>"><?php echo $aResult['areaName'] ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group col-md-2">
                                <label for="inputZip">Status</label>
                                <select id="inputZip" name="status" class="form-control">
                                    <option selected value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" name="customerForm" class="btn btn-primary">Update Data</button>
                        </div>

                    <?php } ?>
                <?php } ?>
            </form>
        </div>


    </div>


    <?php include_once 'footer.php' ?>

</body>

</html>
