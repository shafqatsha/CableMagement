<?php
session_start();
include_once 'object/Customer.php';

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

    <div class="row">
        <div class="container pt-4 ">
            <form method="POST">
                <div class=" d-flex justify-content-center ">

                    <input name="editCustomerName" value="<?php if (isset($_GET['customerReportName'])) echo $_GET['customerReportName']; ?> " disabled>

                </div>

            </form>

        </div>
    </div>
    <div class="row">
        <div class="container pt-4 w-75">

            <!-- some php code -->

            <?php

            if (isset($_GET['customerReportID'])) {
                $searchQuery =  $_GET['customerReportID'];
                $customerEditResult =  $user->searchCustomerByID($searchQuery);
            }







            if (!empty($customerEditResult)) {
                foreach ($customerEditResult as $result) {
                    $totalPayable = $user->totalArrears($result['Customer_ID']);
                }
            }




            ?>

            <!-- some php code end -->
            <form method="POST" action="editCustomersTableOnly.php">
                <!-- Alert Messages -->
                <div style="text-align : center; margin-top:20px !important; width:40%; margin:auto;">
                    <span><?php if (isset($_SESSION['Alert_Update'])) {
                                echo "<div class='alert alert-success'>";
                                echo  $_SESSION['Alert_Update'];
                                echo "</div>";
                                unset($_SESSION['Alert_Update']);
                            } ?> </span>
                </div>
                <!-- Alert Messages End -->
                <!-- start of if  -->
                <?php if (!empty($customerEditResult)) { ?>

                    <?php foreach ($customerEditResult as $result) { ?>

                        <input type="hidden" name="customerID" value="<?php echo $result['Customer_ID']; ?>" />
                        <div class=" form-row">
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Customer Name</label>
                                <input type="text" name="customerName" class="form-control" value="<?php echo $result['name'] ?>" id="inputEmail4" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Mobile Number</label>
                                <input type="number" name="mobileNumber" value="<?php echo $result['mobile'] ?>" class="form-control" id="inputPassword4" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Mobile Number 2</label>
                                <input type="number" name="mobileNumber2" value="<?php echo $result['mobile2'] ?>" class="form-control" id="inputPassword4">
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="connection">Connection Date</label>
                                <input type="date" name="connDate" value="<?php echo $result['connection_date'] ?>" class="form-control" id="connection">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Arrears</label>
                                <input type="number" name="arrears" value="<?php echo $totalPayable['arrears'] ?>" class="form-control" id="inputPassword4" disabled>
                            </div>

                            <div class="form-group col-md-4">

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




                        <!-- fetching city form table -->
                        <?php
                        $user = new User();
                        $cityResutl = $user->selectAllCity();
                        $areaResutl = $user->selectAllArea();

                        ?>





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
                                    <option value="Deactive">Deactive</option>
                                    <option value="Defaulter">Defaulter</option>

                                </select>
                            </div>
                        </div>
                        <button type="submit" name="customerForm" class="btn btn-primary">Update</button>
                        <!-- <div class="d-flex justify-content-center">
                            < </div> <?php } ?>
                             -->
                        <!-- end of foreach -->
                    <?php } ?>
                    <!-- End if  -->
            </form>
        </div>


    </div>


    <?php include_once 'footer.php' ?>

</body>

</html>