<?php
session_start();
include_once 'object/Customer.php'
?>

<?php
$user = new User();
$cityResutl = $user->selectAllCity();
$areaResutl = $user->selectAllArea();

?>

<!DOCTYPE html>
<html lang="en">

<?php include_once 'head.php' ?>
<style>
  #activeAddCustomers {
    background-color: #6200EA;

  }
</style>

<body>
  <?php include_once 'header.php' ?>

  <div class="row">
    <div class="container pt-2 w-50 ">
      <legend class="text-primary">
        <center>
          <h3><b>Add New Connection</b></h3>
        </center>
      </legend><br>
      <form method="POST" action="addCustomerBackEnd.php" autocomplete="off">
        <!-- Alert Messages -->
        <div style="text-align : center; margin-top:20px !important; width:40%; margin:auto;">
          <span><?php if (isset($_SESSION['userWithMobileAlreadyExists'])) {
                  echo "<div class='alert alert-danger'>";
                  echo  $_SESSION['userWithMobileAlreadyExists'];
                  echo "</div>";
                  unset($_SESSION['userWithMobileAlreadyExists']);
                } ?> </span>
        </div>
        <!-- Alert Messages End -->
        <!-- Alert Messages -->
        <div style="text-align : center; margin-top:20px !important; width:40%; margin:auto;">
          <span><?php if (isset($_SESSION['AreaError'])) {
                  echo "<div class='alert alert-danger'>";
                  echo  $_SESSION['AreaError'];
                  echo "</div>";
                  unset($_SESSION['AreaError']);
                } ?> </span>
        </div>
        <!-- Alert Messages End -->
        <!-- Alert Messages -->
        <div style="text-align : center; margin-top:20px !important; width:30%; margin:auto;">
          <span><?php if (isset($_SESSION['RecordCreated'])) {
                  echo "<div class='alert alert-success'>";
                  echo  $_SESSION['RecordCreated'];
                  echo "</div>";
                  unset($_SESSION['RecordCreated']);
                } ?> </span>
        </div>
        <!-- Alert Messages End -->
        <!-- Alert Messages -->
        <div style="text-align : center; margin-top:20px !important; width:30%; margin:auto;">
          <span><?php if (isset($_SESSION['RecordFailed'])) {
                  echo "<div class='alert alert-danger'>";
                  echo  $_SESSION['RecordFailed'];
                  echo "</div>";
                  unset($_SESSION['RecordFailed']);
                } ?> </span>
        </div>
        <!-- Alert Messages End -->
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="inputEmail4">Customer Name</label>
            <input type="text" name="customerName" class="form-control" id="inputEmail4" required placeholder="Name">
          </div>
          <div class="form-group col-md-6">
            <label for="inputPassword4">Mobile Number</label>
            <input type="number" name="mobileNumber" class="form-control" id="inputPassword4" required placeholder="e,g 0300xxxxxxx">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="inputEmail4">Alternative Mobile No</label>
            <input type="number" name="mobileNumber2" class="form-control" id="inputEmail4" placeholder="e,g 0300xxxxxxx">
          </div>
          <div class="form-group col-md-3">
            <label for="inputEmail4">Total Payment</label>
            <input type="number" name="totalPayment" class="form-control" id="inputEmail4" required placeholder="for example 250">
          </div>
          <div class="form-group col-md-3">
            <label for="inputPassword4">Recived Payment</label>
            <input type="number" name="recivedPayment" class="form-control" id="inputPassword4" required placeholder="for example 250">
          </div>
        </div>
        <div class=" form-row ">
          <!-- <div class="form-group col-md-6 ">
            <label for="inputAddress2">Arrears</label>
            <input type="text" name="arrears" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
          </div> -->
          <div class="form-group col-md-6">
            <label for="inputAddress2">Connection Date</label>
            <input type="date" name="con_date" class="form-control" id="inputAddress2" value="<?php echo date('Y-m-d'); ?>">
          </div>

          <div class="form-group col-md-6">
            <label for="inputCity">City</label>
            <select id="inputCity" name="city" class="form-control">
              <?php if (!empty($cityResutl)) { ?>
                <?php foreach ($cityResutl as $result) { ?>
                  <option value="<?php echo $result['cityName']; ?>"><?php echo $result['cityName']; ?></option>


              <?php  }
              } ?>
            </select>
          </div>

        </div>


        <div class="form-row">

          <!-- <div class="form-group col-md-4">
            <label for="inputCity">City</label>
            <select id="inputCity" name="city" class="form-control">
              <option selected>Choose...</option>
              <option>...</option>
            </select>
          </div> -->
          <div class="form-group col-md-6">
            <label for="inputState">Area</label>
            <select id="inputState" name="area" class="form-control" required>
              <option value="areaNotInTheList"> Not In The List</option>
              <?php if (!empty($areaResutl)) { ?>
                <?php foreach ($areaResutl as $result) { ?>
                  <option value="<?php echo $result['areaName']; ?>"><?php echo $result['areaName']; ?></option>


              <?php  }
              } ?>
            </select>
          </div>
          <div class="form-group col-md-4">
            <label for="inputArea">If Area Not In List Type Below</label>
            <input type="text" name="notInTheList" class="form-control" id="inputArea" placeholder="Optional">
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
        <button type="submit" class="btn btn-primary">Add Customer</button>

      </form>



    </div>
  </div>

  <?php include_once 'footer.php' ?>

</body>

</html>