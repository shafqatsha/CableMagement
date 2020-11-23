<?php


class databaseForUser
{

    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "city_cable";
    private $username = "root";
    private $password = "";
    public $conn;

    // get the database connection
    public function getConnection()
    {

        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}


// end of database


// 'user' object
class User extends databaseForUser
{

    // database connection and table name

    private $table_name = "customers";
    private $customerDetailsTable = "customersdetail";
    private $city_table = "city";
    private $area_table = "area";

    // object properties
    public $customerId;
    public $customerName;
    public $mobileNo, $mobileNO2;

    public $fee_paid;
    public $fee_payable;
    public $arrears;
    public $area;
    public $paid_date;
    public $conn_date;
    public $status, $totalFee;

    public $city;




    // Check if same user already Exists using mobile number


    function mobileExists()
    {

        // query to check if email exists
        $query = "SELECT Customer_ID, name
            FROM customers
            WHERE mobile = ?";

        $stmt = $this->getConnection()->prepare($query);

        $this->mobileNo = htmlspecialchars(strip_tags($this->mobileNo));

        $stmt->bindParam(1, $this->mobileNo);

        $stmt->execute();
        // get number of rows
        $numberOfRows = $stmt->rowCount();

        if ($numberOfRows > 0) {
            // get record details / values
            // $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // $_SESSION['id'] = $row['ID'];
            // $this->firstName = $row['FirstName'];
            // $this->lastName = $row['LastName'];
            // $this->password = $row['Password'];
            // $this->accountType = $row['AccountType'];

            // Return True
            return true;
        }
        // Return False if email does not exists
        return false;
    }


    // End of Function Checking the user

    // create new user record
    function create()
    {


        // insert query
        $query = "INSERT INTO
                " . $this->table_name . "
            SET
               
                name = :customerName,
                mobile =:mobileNo,
                mobile2 = :mobileNO2,
                area = :area,
                city = :city,
                status= :status,
                connection_date = :conn_date";

        $stmt = $this->getConnection()->prepare($query);

        $this->customerName = htmlspecialchars(strip_tags($this->customerName));
        $this->mobileNo = htmlspecialchars(strip_tags($this->mobileNo));
        $this->area = htmlspecialchars(strip_tags($this->area));
        $this->city = htmlspecialchars(strip_tags($this->city));
        $this->conn_date = htmlspecialchars(strip_tags($this->conn_date));
        $this->status = htmlspecialchars(strip_tags($this->status));

        $stmt->bindParam(':customerName', $this->customerName);
        $stmt->bindParam(':mobileNo', $this->mobileNo);
        $stmt->bindParam(':mobileNO2', $this->mobileNO2);
        $stmt->bindParam(':area', $this->area);
        $stmt->bindParam(':city', $this->city);
        $stmt->bindParam(':conn_date', $this->conn_date);
        $stmt->bindParam(':status', $this->status);


        // execute the query

        if ($stmt->execute()) {


            return true;
        } else {
            return false;
        }
    }
    // End of create Function

    // Select All Customer from dataBase
    function selectAllCustomer()
    {
        $sql = "SELECT * from  customers WHERE STATUS <> 'Defaulter' ";

        $result = $this->getConnection()->query($sql);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch()) {
                $data[] = $row;
            }
            return $data;
        }
    }

    // Deactive and inactive filter

    function selectAllDeactive()
    {
        $sql = "SELECT customers.*, SUM(customersdetail.arrears) as totalArrears,SUM(customersdetail.fee_paid) as totalPaid FROM customers INNER JOIN customersdetail ON customers.Customer_ID = customersdetail.CustomerDetailForignID WHERE customers.status = 'Deactive' GROUP BY customersdetail.CustomerDetailForignID ";

        $result = $this->getConnection()->query($sql);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch()) {
                $data[] = $row;
            }
            return $data;
        }
    }
    function selectAllInactive()
    {
        $sql = "SELECT customers.*, SUM(customersdetail.arrears) as totalArrears,SUM(customersdetail.fee_paid) as totalPaid FROM customers INNER JOIN customersdetail ON customers.Customer_ID = customersdetail.CustomerDetailForignID WHERE customers.status = 'Inactive' GROUP BY customersdetail.CustomerDetailForignID ";

        $result = $this->getConnection()->query($sql);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch()) {
                $data[] = $row;
            }
            return $data;
        }
    }
    function selectAllDefaulters()
    {
        $sql = "SELECT customers.*, SUM(customersdetail.arrears) as totalArrears,SUM(customersdetail.fee_paid) as totalPaid FROM customers INNER JOIN customersdetail ON customers.Customer_ID = customersdetail.CustomerDetailForignID WHERE customers.status = 'Defaulter' GROUP BY customersdetail.CustomerDetailForignID ";

        $result = $this->getConnection()->query($sql);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch()) {
                $data[] = $row;
            }
            return $data;
        }
    }

    // End of Function

    function yearlySum()
    {
    }

    // Select All Customer from dataBase
    function selectAllCustomerDetail($ID)
    {
        $sql = "SELECT SUM(fee_paid) as FeeSum, SUM(arrears) as ArrearsSum from  " . $this->customerDetailsTable .  " WHERE CustomerDetailForignID = " . $ID;

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);


        return $result;
    }
    // End of Function
    // Select All City from dataBase
    function selectAllCity()
    {

        $sql = "SELECT * from  " . $this->city_table;

        $result = $this->getConnection()->query($sql);
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch()) {
                $data[] = $row;
            }
            return $data;
        }
    }
    // End of Function


    // Select All Area from area Table

    function selectAllArea()
    {

        $sql = "SELECT * from  " . $this->area_table;

        $result = $this->getConnection()->query($sql);
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch()) {
                $data[] = $row;
            }
            return $data;
        }
    }

    // Searching Defaulters

    function searchDefaulterCustomer($search)
    {
        $sql = "SELECT * FROM customers WHERE name LIKE ? and status = 'Defaulter'";

        $result = $this->getConnection()->prepare($sql);

        $result->bindValue(1, "%$search%", PDO::PARAM_STR);



        $result->execute();


        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

            $data[] = $row;
        }
        if (!empty($data)) {
            return $data;
        } else
            return false;
    }


    // search function using sql LIKE for the page view Customer front



    function searchCustomerViewFront($search)
    {
        // $sql = "SELECT * FROM customers WHERE STATUS <> 'Defaulter' and name like %" . $search  . "%";



        // $result = $this->getConnection()->prepare($sql);

        // $search = htmlspecialchars(strip_tags($search));

        // $result->bindValue('%$search%', PDO::PARAM_STR);
        // $defaulter = 'defaulter';
        $sql = "SELECT * FROM customers WHERE name LIKE ? and status != 'Defaulter'";

        $result = $this->getConnection()->prepare($sql);

        $result->bindValue(1, "%$search%", PDO::PARAM_STR);



        $result->execute();


        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

            $data[] = $row;
        }
        if (!empty($data)) {
            return $data;
        } else
            return false;
    }
    //  End function Search


    function search($search)
    {
        $sql = "SELECT * from  customers WHERE name = :search LIMIT 1";



        $result = $this->getConnection()->prepare($sql);
        $result->bindParam(':search', $search);


        $result->execute();


        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

            $data[] = $row;
        }
        if (!empty($data)) {
            return $data;
        } else
            return false;
    }
    //  End function Search


    // Update customer function

    function updateCustomer($customerID)
    {

        $sql = " UPDATE " . $this->table_name . "
        SET 
      
        name = :customerName,
        mobile =:mobileNo,
        mobile2=:mobileNO2,
        area = :area,
        city = :city,
        status= :status,
        connection_date = :conn_date
        WHERE Customer_ID = :customerID";


        $stmt = $this->getConnection()->prepare($sql);
        $this->customerName = htmlspecialchars(strip_tags($this->customerName));
        $this->mobileNo = htmlspecialchars(strip_tags($this->mobileNo));
        $this->mobileNO2 = htmlspecialchars(strip_tags($this->mobileNO2));

        $this->area = htmlspecialchars(strip_tags($this->area));
        $this->city = htmlspecialchars(strip_tags($this->city));
        $this->conn_date = htmlspecialchars(strip_tags($this->conn_date));
        $this->status = htmlspecialchars(strip_tags($this->status));

        $stmt->bindParam(':customerName', $this->customerName);
        $stmt->bindParam(':mobileNo', $this->mobileNo);
        $stmt->bindParam(':mobileNO2', $this->mobileNO2);

        $stmt->bindParam(':area', $this->area);
        $stmt->bindParam(':city', $this->city);
        $stmt->bindParam(':conn_date', $this->conn_date);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':customerID', $customerID);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Update customer function end

    function insertIntoCustomerDetails($cid)
    {

        // insert query
        $query = "INSERT INTO
       " . $this->customerDetailsTable . "
     SET
      
       fee_paid = :fee_paid,
       arrears =:arrears,
       paid_date = :paid_date,
       CustomerDetailForignID = :cid";

        $stmt = $this->getConnection()->prepare($query);

        $this->fee_paid = htmlspecialchars(strip_tags($this->fee_paid));
        $this->arrears = htmlspecialchars(strip_tags($this->arrears));
        $this->paid_date = htmlspecialchars(strip_tags($this->paid_date));

        $stmt->bindParam(':fee_paid', $this->fee_paid);
        $stmt->bindParam(':arrears', $this->arrears);
        $stmt->bindParam(':cid', $cid);
        $stmt->bindParam(':paid_date', $this->paid_date);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


    // start of funxtion SUM of ARREARS


    function totalArrears($id)
    {
        $sql = "SELECT SUM(arrears) as arrears FROM " . $this->customerDetailsTable . " WHERE CustomerDetailForignID = " . $id;
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);


        return $result;
    }

    // Add Area And Add City Functions

    function addCity($city)

    {

        $sql = "INSERT  INTO city SET  cityName =:city";

        $stmt = $this->getConnection()->prepare($sql);

        // strip tags

        $city = htmlspecialchars(strip_tags($city));

        // bind Posted Values
        $stmt->bindParam(':city', $city);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    function addArea($area)
    {
        $sql = "INSERT  INTO area SET  areaName =:area";

        $stmt = $this->getConnection()->prepare($sql);

        // strip tags

        $city = htmlspecialchars(strip_tags($area));

        // bind Posted Values
        $stmt->bindParam(':area', $area);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


    // delete customer form Customer Table and CustomerDetail Table

    function deleteFromCustomer($deleteCustomer)
    {
        $sql = "DELETE FROM customers WHERE Customer_ID = :deleteCustomer";

        $stmt =  $this->getConnection()->prepare($sql);

        $deleteCustomer = htmlspecialchars(strip_tags($deleteCustomer));

        // bind Posted Values
        $stmt->bindParam(':deleteCustomer', $deleteCustomer);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function deleteFromCustomerDetail($id)
    {
        $sql = "DELETE FROM customersdetail WHERE CustomerDetailForignID = :id";

        $stmt =  $this->getConnection()->prepare($sql);

        $id = htmlspecialchars(strip_tags($id));

        // bind Posted Values
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    // Delete Area And City
    function deleteFromCity($deleteCity)
    {
        $sql = "DELETE FROM city WHERE city_id = :deleteCity";

        $stmt =  $this->getConnection()->prepare($sql);

        $deleteCity = htmlspecialchars(strip_tags($deleteCity));

        // bind Posted Values
        $stmt->bindParam(':deleteCity', $deleteCity);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    function deleteFromArea($deleteArea)
    {
        $sql = "DELETE FROM area WHERE area_id = :deleteArea";

        $stmt =  $this->getConnection()->prepare($sql);

        $deleteArea = htmlspecialchars(strip_tags($deleteArea));

        // bind Posted Values
        $stmt->bindParam(':deleteArea', $deleteArea);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Function to search from customers Table By ID

    function searchCustomerByID($search)
    {
        $sql = "SELECT * from  customers WHERE Customer_ID = :search";



        $result = $this->getConnection()->prepare($sql);
        $result->bindParam(':search', $search);


        $result->execute();


        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

            $data[] = $row;
        }
        if (!empty($data)) {
            return $data;
        } else
            return false;
    }
    //  End function Search

    //function to make Yearly Report

    function generateYearlyReport($startDate, $endDate, $customerID)
    {

        $startDate = date('Y', strtotime($startDate));
        $endDate = date('Y', strtotime($endDate));


        $sql = "SELECT CustomerDetailForignID, SUM(fee_paid) as feeSum, SUM(arrears) AS arrearsSum, paid_date from  customersdetail 
        WHERE 
        CustomerDetailForignID = :customerID AND YEAR(paid_date) between :startDate AND :endDate GROUP BY YEAR(paid_date)";



        $result = $this->getConnection()->prepare($sql);
        $result->bindParam(':startDate', $startDate);
        $result->bindParam(':endDate', $endDate);
        $result->bindParam(':customerID', $customerID);


        $result->execute();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

            $data[] = $row;
        }
        if (!empty($data)) {
            return $data;
        } else
            return false;
    }
    // function to make a monthly report

    function generateReport($startDate, $endDate, $customerID)
    {
        $sql = "SELECT * from  customersdetail 
        WHERE 
        CustomerDetailForignID = :customerID AND paid_date between :startDate AND :endDate ";



        $result = $this->getConnection()->prepare($sql);
        $result->bindParam(':startDate', $startDate);
        $result->bindParam(':endDate', $endDate);
        $result->bindParam(':customerID', $customerID);


        $result->execute();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

            $data[] = $row;
        }
        if (!empty($data)) {
            return $data;
        } else
            return false;
    }


    // Filter Option Code for the Page view Customer front end
    function notPaidFilter()
    {
        $notPaid = 0;
        $sql = "SELECT c.Customer_ID, d.CustomerDetailForignID, c.name, c.mobile,c.area,c.city,c.status FROM  customers as c, customersdetail as d WHERE d.fee_paid = 0 AND
      c.Customer_ID  =  d.CustomerDetailForignID GROUP BY d.CustomerDetailForignID";

        $result = $this->getConnection()->prepare($sql);
        // $result->bindParam(':startDate', $startDate);
        // $result->bindParam(':endDate', $endDate);
        // $result->bindParam(':notPaid', $notPaid);


        $result->execute();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

            $data[] = $row;
        }
        if (!empty($data)) {
            return $data;
        } else
            return false;
    }

    // arrears Sum function

    function paidFilter()
    {



        $notPaid = 0;
        $sql = "SELECT c.Customer_ID, d.CustomerDetailForignID, c.name, c.mobile,c.area,c.city,c.status FROM  customers as c, customersdetail as d WHERE d.arrears = 0 AND
        c.Customer_ID  =  d.CustomerDetailForignID GROUP BY d.CustomerDetailForignID";
        $result = $this->getConnection()->prepare($sql);
        // $result->bindParam(':startDate', $startDate);
        // $result->bindParam(':endDate', $endDate);
        $result->bindParam(':notPaid', $notPaid);


        $result->execute();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

            $data[] = $row;
        }
        if (!empty($data)) {
            return $data;
        } else
            return false;
    }
    function arrearsFilter()
    {
        $notPaid = 0;
        $sql = "SELECT c.Customer_ID, d.CustomerDetailForignID, c.name, c.mobile,c.area,c.city,c.status FROM  customers as c, customersdetail as d WHERE d.arrears > 0 AND
      c.Customer_ID  =  d.CustomerDetailForignID GROUP BY d.CustomerDetailForignID";

        $result = $this->getConnection()->prepare($sql);
        // $result->bindParam(':startDate', $startDate);
        // $result->bindParam(':endDate', $endDate);
        $result->bindParam(':notPaid', $notPaid);


        $result->execute();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

            $data[] = $row;
        }
        if (!empty($data)) {
            return $data;
        } else
            return false;
    }

    // Fetch Last Row From Customers Table so that we can use that id to insert Record iNto CustomersDetailID Table

    function getLastInsertedResult()
    {

        $sql = "Select Customer_ID from customers ORDER BY Customer_ID DESC LIMIT 1";

        $result = $this->getConnection()->prepare($sql);

        $result->execute();


        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

            $data[] = $row;
        }
        if (!empty($data)) {
            return $data;
        } else
            return false;
    }


    function sortByPayable($sort)
    {
        $sql = "SELECT customers.*, SUM(customersdetail.arrears) as totalArrears,SUM(customersdetail.fee_paid) as totalPaid FROM customers INNER JOIN customersdetail ON customers.Customer_ID = customersdetail.CustomerDetailForignID GROUP BY customersdetail.CustomerDetailForignID  ORDER BY totalArrears  " . $sort;

        $result = $this->getConnection()->prepare($sql);

        $result->execute();


        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

            $data[] = $row;
        }
        if (!empty($data)) {
            return $data;
        } else
            return false;
    }

    // CountAll  Customers

    function countAllCustomers()
    {
        $sql = "SELECT count(*) as totalResult from customers";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);


        return $result;
    }
    // select limited customers from database for pagination

    function selectLimitedCustomer($startPage, $endPage)
    {
        $sql = "SELECT * FROM customers LIMIT " . $startPage . "," . $endPage;

        $result = $this->getConnection()->prepare($sql);
        // $result->bindParam(':search', $search);


        $result->execute();


        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

            $data[] = $row;
        }
        if (!empty($data)) {
            return $data;
        } else
            return false;
    }
}
