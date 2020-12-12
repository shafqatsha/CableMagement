<?php
session_start();
include_once 'object/Customer.php';
$user = new User();


// some php code for pagination

if (isset($_GET['page'])) {
  $page = $_GET['page'];
} else {
  $page = 1;
}
$number_of_results = $user->countAllCustomers();
// define how many results you want per page
$results_per_page = 13;
// Determine total number of pages available
$totalPages = ceil($number_of_results['totalResult'] / $results_per_page);
// determine which page number visitor is currently on


$this_page_results = ($page - 1) * $results_per_page;

$pageResult = $user->selectLimitedCustomer($this_page_results, $results_per_page);

if (isset($_GET['name'])) {



  if (($_GET['name']) == "NotPaid") {

    $notPaidResult =  $user->notPaidFilter();
  } else if (($_GET['name']) == "Paid") {
    $paidResult = $user->paidFilter();
  } else if (($_GET['name']) == "Deactive") {
    $DeactiveResult = $user->selectAllDeactive();
  } else if (($_GET['name']) == "Inactive") {
    $InactiveResult = $user->selectAllInactive();
  } else if (($_GET['name']) == "Arrears") {
    $arrearsResult =  $user->arrearsFilter();
  } else if ($_GET['name'] == 'ASC') {
    $sort = 'DESC';
    $sortByArrears =  $user->sortByPayable($sort);
  } else {
    $sort = 'ASC';
    $sortByArrears =  $user->sortByPayable($sort);
  }
}

// if (isset($_GET['sort']) && $_GET['sort'] == 'ASC') {
//   $sort = 'DESC';
//   $sortByArrears =  $user->sortByPayable($sort);
// } else {
//   $sort = 'ASC';
//   $sortByArrears =  $user->sortByPayable($sort);
// }



// Form Search Button on Top in ViewCustomerFrontPage

if (isset($_POST['searchCustomerForm'])) {
  $search = $_POST['search'];
  if (isset($_GET['name'])) {
    $_GET['name'] = 'search';
  } else {
    $_GET['name'] = 'search';
  }

  if ($user->searchCustomerViewFront($search)) {
    $customerSearchResult = $user->searchCustomerViewFront($search);
  } else {
    $_SESSION['resultNotFound'] = "No Result Found";
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<?php include_once 'head.php' ?>

<style>
  #activeHome {
    background-color: #6200EA;
  }
</style>

<body>
  <?php include_once 'header.php' ?>


  <form method="POST">
    <div class="input-group container w-25 justify-content-center mb-3 pt-3">

      <input type="text" name="search" id="SearchName" class="form-control" placeholder="Enter Name" aria-label="Recipient's username" aria-describedby="basic-addon2" autocomplete="off">
      <div class="input-group-append">
        <input type="submit" class=" btn-primary  " name="searchCustomerForm" value="Search">

      </div>

    </div>
  </form>

  <div class="float-left  ">
    <ul class="nav flex-column m-3 ">
      <li class="nav-item">
        <label class=" form-control ">Filter Options</label>
      </li>
      <ul class="nav flex-column">
        <form>
          <li class="nav-item">
            <a class="nav-link btn-primary " href="Index.php?name=NotPaid">Not Paid</a>
          </li>

        </form>


        <li class="nav-item">
          <a class="nav-link btn-primary " href="Index.php?name=Paid">Paid</a>
        </li>
        <li class="nav-item">
          <a class="nav-link btn-primary  " href="Index.php?name=Arrears">Arrears</a>
        </li>
        <li class="nav-item">
          <a class="nav-link btn-primary  " href="Index.php?name=Deactive">Deactive</a>
        </li>
        <li class="nav-item">
          <a class="nav-link btn-primary  " href="Index.php?name=Inactive">Inactive</a>
        </li>

        <li class="nav-item">
          <a class="nav-link btn-primary " href="Index.php?name=ClearFilter">Clear Filters</a>
        </li>


      </ul>

  </div>
  <!-- some php code to fetch data from customer and customer detail tables -->
  <?php
  $user = new User();

  $customerResult = $user->selectAllCustomer();

  ?>

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
            <?php if (!isset($sort)) $sort =  'ASC'; ?>
            <?php if (isset($_GET['name']) && $_GET['name'] == 'ASC') { ?>
              <th scope="col">
                <a href="Index.php?name=<?php echo $sort ?>"><svg class="bi" width="18" height="20" fill="currentColor">
                    <use xlink:href="node_modules/bootstrapIcons/bootstrap-icons.svg#arrow-up-short" />
                  </svg>Payable</a>

              </th>
            <?php } else if (isset($_GET['name']) && $_GET['name'] == 'DESC') { ?>
              <th scope="col"><a href="Index.php?name=<?php echo $sort ?>">Arrears<svg class="bi" width="18" height="20" fill="currentColor">
                    <use xlink:href="node_modules/bootstrapIcons/bootstrap-icons.svg#arrow-down-short" />
                  </svg></a>

              </th>
            <?php } else { ?>
              <th scope="col"> <a href="Index.php?name=<?php echo $sort ?>"><svg class="bi" width="18" height="20" fill="currentColor">
                    <use xlink:href="node_modules/bootstrapIcons/bootstrap-icons.svg#arrow-down-short" />
                  </svg>Arrears<svg class="bi" width="18" height="20" fill="currentColor">
                    <use xlink:href="node_modules/bootstrapIcons/bootstrap-icons.svg#arrow-up-short" />
                  </svg></a>

              </th>
            <?php } ?>
            <th scope="col">Paid</th>
            <th scope="col ">Action</th>

          </tr>
        </thead>
        <tbody>

          <div style="text-align : center; margin-top:5px !important; width:50%; margin:auto;">
            <span><?php if (isset($_SESSION['resultNotFound'])) {
                    echo "<div class='alert alert-danger'>";
                    echo  $_SESSION['resultNotFound'];
                    echo "</div>";
                    unset($_SESSION['resultNotFound']);
                  } ?> </span>
          </div>

          <?php if (!empty($sortByArrears) && isset($_GET['name']) && ($_GET['name'] == 'ASC' || $_GET['name'] == 'DESC')) { ?>

            <?php foreach ($sortByArrears as $aResult) { ?>
              <tr>
                <th scope="row"><?php echo $aResult['Customer_ID'] ?></th>
                <td><?php echo $aResult['name'] ?></td>
                <td><?php echo $aResult['mobile'] ?></td>
                <td><?php echo $aResult['city'] ?></td>
                <td><?php echo $aResult['area'] ?></td>
                <td><?php echo $aResult['status'] ?></td>

                <!-- <?php $feeSUM = $user->selectAllCustomerDetail($aResult['Customer_ID']) ?> -->
                <td><?php if (!empty($feeSUM))  echo $aResult['totalArrears'] ?></td>
                <td><?php if (!empty($feeSUM))  echo $aResult['totalPaid'] ?></td>


                <td><a type="button" class="btn btn-sm btn-primary" href="generateReportFront.php?customerReportID=<?php echo $aResult['Customer_ID'] ?>&customerReportName=<?php echo $aResult['name'] ?> ">Report</a></td>

                <td><a type="button" class="btn btn-sm btn-danger" href="Edit.php?customerReportID=<?php echo $cusResult['Customer_ID'] ?>&customerReportName=<?php echo $cusResult['name'] ?>  ">Edit</a></td>
                <td><a type="button" class="btn btn-sm btn-success" href="EditCustomersFront.php?editCustomerName=<?php echo $aResult['name'] ?> ">Pay Fees</a></td>




              </tr>
            <?php } ?>
            <!-- end of foreach -->
          <?php } else if (!empty($InactiveResult) && isset($_GET['name']) && $_GET['name'] == "Inactive") { ?>
            <!-- end of if start of else if -->
            <?php foreach ($InactiveResult as $cusResult) { ?>

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

                <td><a type="button" class="btn btn-sm btn-primary" href="generateReportFront.php?customerReportID=<?php echo $cusResult['Customer_ID'] ?>&customerReportName=<?php echo $aResult['name'] ?> ">Report</a></td>

                <td><a type="button" class="btn btn-sm btn-danger" href="Edit.php?customerReportID=<?php echo $cusResult['Customer_ID'] ?>&customerReportName=<?php echo $cusResult['name'] ?> ">Edit</a></td>
                <td><a type="button" class="btn btn-sm btn-success" href="EditCustomersFront.php?editCustomerName=<?php echo $cusResult['name'] ?> ">Pay Fees</a></td>

              </tr>



            <?php } ?>
            <!-- end of foreach loop -->

            <!-- Start of Not Paid Filter Result to show in table -->
          <?php } else if (!empty($DeactiveResult) && isset($_GET['name']) && $_GET['name'] == "Deactive") { ?>
            <!-- end of if start of else if -->
            <?php foreach ($DeactiveResult as $cusResult) { ?>

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

                <td><a type="button" class="btn btn-sm btn-primary" href="generateReportFront.php?customerReportID=<?php echo $cusResult['Customer_ID'] ?>&customerReportName=<?php echo $aResult['name'] ?> ">Report</a></td>

                <td><a type="button" class="btn btn-sm btn-danger" href="Edit.php?customerReportID=<?php echo $cusResult['Customer_ID'] ?>&customerReportName=<?php echo $cusResult['name'] ?> ">Edit</a></td>
                <td><a type="button" class="btn btn-sm btn-success" href="EditCustomersFront.php?editCustomerName=<?php echo $cusResult['name'] ?> ">Pay Fees</a></td>

              </tr>



            <?php } ?>
            <!-- end of foreach loop -->

            <!-- Start of Not Paid Filter Result to show in table -->
          <?php } else if (!empty($arrearsResult) && isset($_GET['name']) && $_GET['name'] == "Arrears") { ?>
            <!-- end of if start of else if -->
            <?php foreach ($arrearsResult as $aResult) { ?>
              <?php $feeSUM = $user->selectAllCustomerDetail($aResult['Customer_ID']) ?>
              <?php if ($feeSUM['ArrearsSum'] != 0) { ?>
                <tr>
                  <th scope="row"><?php echo $aResult['Customer_ID'] ?></th>
                  <td><?php echo $aResult['name'] ?></td>
                  <td><?php echo $aResult['mobile'] ?></td>
                  <td><?php echo $aResult['city'] ?></td>
                  <td><?php echo $aResult['area'] ?></td>
                  <td><?php echo $aResult['status'] ?></td>

                  <td><?php if (!empty($feeSUM))  echo $feeSUM['ArrearsSum'] ?></td>
                  <td><?php if (!empty($feeSUM))  echo $feeSUM['FeeSum'] ?></td>


                  <td><a type="button" class="btn btn-sm btn-primary" href="generateReportFront.php?customerReportID=<?php echo $aResult['Customer_ID'] ?>&customerReportName=<?php echo $aResult['name'] ?> ">Report</a></td>

                  <td><a type="button" class="btn btn-sm btn-danger" href="Edit.php?customerReportID=<?php echo $cusResult['Customer_ID'] ?>&customerReportName=<?php echo $aResult['name'] ?> ">Edit</a></td>
                  <td><a type="button" class="btn btn-sm btn-success" href="EditCustomersFront.php?editCustomerName=<?php echo $aResult['name'] ?> ">Pay Fees</a></td>




                </tr>
              <?php } ?>

              <!-- End of if statement -->
            <?php } ?>
            <!-- end of foreach loop -->

            <!-- Start of Not Paid Filter Result to show in table -->
          <?php } else if (!empty($paidResult) && isset($_GET['name']) && $_GET['name'] == "Paid") { ?>
            <!-- end of if and start of else if -->
            <?php foreach ($paidResult as $pResult) { ?>

              <?php $feeSUM = $user->selectAllCustomerDetail($pResult['Customer_ID']) ?>
              <?php if (!empty($feeSUM) && $feeSUM['ArrearsSum'] == 0) { ?>
                <th scope="row"><?php echo $pResult['Customer_ID'] ?></th>
                <td><?php echo $pResult['name'] ?></td>
                <td><?php echo $pResult['mobile'] ?></td>
                <td><?php echo $pResult['city'] ?></td>
                <td><?php echo $pResult['area'] ?></td>
                <td><?php echo $pResult['status'] ?></td>

                <td><?php if (!empty($feeSUM))  echo $feeSUM['ArrearsSum'] ?></td>
                <td><?php if (!empty($feeSUM))  echo $feeSUM['FeeSum'] ?></td>


                <td><a type="button" class="btn btn-sm btn-primary" href="generateReportFront.php?customerReportID=<?php echo $pResult['Customer_ID'] ?>&customerReportName=<?php echo $pResult['name'] ?> ">Report</a></td>

                <td><a type="button" class="btn btn-sm btn-danger" href="Edit.php?customerReportID=<?php echo $cusResult['Customer_ID'] ?>&customerReportName=<?php echo $cusResult['name'] ?> ">Edit</a></td>
                <td><a type="button" class="btn btn-sm btn-success" href="EditCustomersFront.php?editCustomerName=<?php echo $pResult['name'] ?> ">Pay Fees</a></td>




                </tr>
              <?php } ?>
            <?php } ?>
            <!-- end of foreach loop -->

            <!-- Start of Not Paid Filter Result to show in table -->
          <?php } else if (!empty($notPaidResult) && isset($_GET['name']) && $_GET['name'] == "NotPaid") { ?>
            <!-- end of  if and start of else -->
            <?php foreach ($notPaidResult as $npResult) { ?>
              <?php $feeSUM = $user->selectAllCustomerDetail($npResult['Customer_ID']) ?>
              <?php if ($feeSUM['FeeSum'] == 0) { ?>
                <tr>
                  <th scope="row"><?php echo $npResult['Customer_ID'] ?></th>
                  <td><?php echo $npResult['name'] ?></td>
                  <td><?php echo $npResult['mobile'] ?></td>
                  <td><?php echo $npResult['city'] ?></td>
                  <td><?php echo $npResult['area'] ?></td>
                  <td><?php echo $npResult['status'] ?></td>

                  <td><?php if (!empty($feeSUM))  echo $feeSUM['ArrearsSum'] ?></td>
                  <td><?php if (!empty($feeSUM))  echo $feeSUM['FeeSum'] ?></td>


                  <td><a type="button" class="btn btn-sm btn-primary" href="generateReportFront.php?customerReportID=<?php echo $npResult['Customer_ID'] ?>&customerReportName=<?php echo $npResult['name'] ?> ">Report</a></td>

                  <td><a type="button" class="btn btn-sm btn-danger" href="Edit.php?customerReportID=<?php echo $cusResult['Customer_ID'] ?>&customerReportName=<?php echo $cusResult['name'] ?> ">Edit</a></td>
                  <td><a type="button" class="btn btn-sm btn-success" href="EditCustomersFront.php?editCustomerName=<?php echo $npResult['name'] ?> ">Pay Fees</a></td>




                </tr>
              <?php } ?>
              <!-- end of if -->
            <?php } ?>
            <!-- End of for Loop -->
            <!-- Start of Search Button Filter  -->



          <?php } else  if (!empty($customerSearchResult) && isset($_GET['name']) && $_GET['name'] = 'search') { ?>

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
          <?php } else if (!empty($pageResult)) { ?>
            <?php foreach ($pageResult as $cusResult) { ?>

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

                <td><a type="button" class="btn btn-sm btn-danger" href="Edit.php?customerReportID=<?php echo $cusResult['Customer_ID'] ?>&customerReportName=<?php echo $cusResult['name'] ?> ">Edit</a></td>
                <td><a type="button" class="btn btn-sm btn-success" href="EditCustomersFront.php?editCustomerName=<?php echo $cusResult['name'] ?> ">Pay Fees</a></td>

              </tr>



            <?php } ?>

            <nav aria-label="Page navigation example">
              <ul class="pagination justify-content-center">
                <?php if ($page == 1) { ?>
                  <li class="page-item disabled">

                    <a class="page-link" href="#" tabindex="-1" aria-label="Previous">

                      <span aria-hidden="true">&laquo;</span>
                      <span class="sr-only">Previous</span>
                    </a>
                  </li>
                <?php } else { ?>
                  <li class="page-item ">

                    <a class="page-link" href="index.php?page=<?php echo $page - 1 ?>" aria-label="Previous">

                      <span aria-hidden="true">&laquo;</span>
                      <span class="sr-only">Previous</span>
                    </a>
                  </li>

                <?php } ?>
                <?php for ($page = 1; $page <= $totalPages; $page++) { ?>

                  <li class="page-item"><a class="page-link" href="index.php?page=<?php echo $page ?>"><?php echo $page ?></a></li>
                <?php } ?>
                <!-- <li class="page-item active">
            <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
          </li>
          <li class="page-item"><a class="page-link" href="#">3</a></li> -->

                <!-- -->

                <?php if (isset($_GET['page'])  && $_GET['page'] < $totalPages) { ?>
                  <li class="page-item">
                    <a class="page-link" href="index.php?page=<?php if (isset($_GET['page'])) {
                                                                $page = $_GET['page'];
                                                                echo $page + 1;
                                                              }
                                                              ?>" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                      <span class="sr-only">Next</span>
                    </a>
                  </li>
                <?php } else { ?>
                  <li class="page-item disabled">
                    <a class="page-link" tabindex="-1" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                      <span class="sr-only">Next</span>
                    </a>
                  </li>

                <?php } ?>

              </ul>
            </nav>
          <?php } ?>
          <!-- end of else if -->



        </tbody>

      </table>
      <!-- Paging Link -->





    </div>
  </div>

  <?php include_once 'footer.php' ?>


  <script>
    $(function() {
      $("#SearchName").autocomplete({
        source: "search.php",
        select: function(event, ui) {
          event.preventDefault();
          $("#SearchName").val(ui.item.id).show();
        }
      });
    });
  </script>

</body>

</html>
