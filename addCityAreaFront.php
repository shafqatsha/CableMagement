<?php
session_start();
include_once 'object/Customer.php'
?>

<!DOCTYPE html>
<html lang="en">

<?php include_once 'head.php' ?>
<style>
    #activeCityArea {

        background-color: #6200EA;
    }
</style>

<body>
    <?php include_once 'header.php' ?>


    <div class="row w-50  m-auto pt-4 ">

        <div class=" w-50 float-left ">
            <form action="addCityAreaBackEnd.php" method="POST">
                <div class=" float-left input-group input-group-sm mb-3 m-auto pr-3">

                    <input type="text" class="form-control" name="addCity" required>
                    <div class="input-group-prepend">
                        <input type="submit" class=" input-group-text text-white bg-primary" name="cityForm" value="Add City">
                    </div>

                </div>
            </form>
        </div>
        <div class=" w-50 float-left ">
            <form method="POST" action="addCityAreaBackEnd.php">
                <div class="  float-left input-group input-group-sm mb-3 m-auto pl-3">

                    <input type="text" class="form-control" name="addArea" required>
                    <div class="input-group-prepend">
                        <input type="submit" name="areaForm" class=" input-group-text   text-white bg-primary" value="Add Area">
                    </div>

                </div>
            </form>
        </div>

        <!-- Starting of table html code and PHP OF CODE-->

        <?php
        $user = new User();
        $cityResutl = $user->selectAllCity();
        $areaResutl = $user->selectAllArea();

        ?>

        <div class=" container m-auto   pt-5  ">

            <div class="  float-left">
                <legend>
                    <left>
                        <h4><b class="text-primary">City</b></h4>
                    </left>
                </legend>
                <table class="table table-inverse table-sm table-hover ">
                    <thead class="thead-inverse">

                        <tr>
                            <th>ID</th>
                            <th>City Name</th>
                            <th>Action</th>

                        </tr>

                    </thead>
                    <tbody>
                        <?php if (!empty($cityResutl)) { ?>
                            <?php foreach ($cityResutl as $result) { ?>
                                <tr>
                                    <td scope="row"><?php echo $result['city_id']; ?></td>

                                    <td><?php echo $result['cityName']; ?></td>
                                    <td><a class="btn btn-danger btn-sm" href="deleteCityArea.php?cid=<?php echo $result['city_id'] ?>">Delete</a></td>

                                </tr>
                            <?php } ?>
                        <?php } ?>

                    </tbody>
                </table>

            </div>

            <div class="float-right ">
                <legend>
                    <left>
                        <h4><b class="text-primary">Area</b></h4>
                    </left>
                </legend>
                <table class="table table-inverse table-sm table-hover  ">
                    <thead class="thead-inverse">
                        <tr>
                            <th>Area Id</th>
                            <th>Area Name</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($areaResutl)) { ?>
                            <?php foreach ($areaResutl as $result) { ?>
                                <tr>
                                    <td scope="row"><?php echo $result['area_id']; ?></td>

                                    <td><?php echo $result['areaName']; ?></td>
                                    <td><a class="btn btn-danger btn-sm" href="deleteCityArea.php?aid=<?php echo $result['area_id'] ?>">Delete</a></td>

                                </tr>
                            <?php } ?>
                        <?php } ?>

                    </tbody>
                </table>

            </div>

        </div>
    </div>


    <!-- Ending of table html code and PHP OF CODE-->





    <?php include_once 'footer.php' ?>

</body>

</html>