<?php
// Database configuration 
$dbHost = "localhost";
$dbName = "city_cable";
$dbUsername = "root";
$dbPassword = "";

// Create database connection 
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection 
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Get search term 
$searchTerm = $_GET['term'];

// Fetch matched data from the database 
$query = $db->query("SELECT Customer_ID, name FROM customers WHERE name LIKE '%" . $searchTerm . "%'");

// Generate array with skills data 
$skillData = array();
if ($query->num_rows > 0) {
    while ($row = $query->fetch_assoc()) {
        $data['id'] = $row['Customer_ID'];
        $data['value'] = $row['name'];
        array_push($skillData, $data);
    }
}

// Return results as json encoded array 


echo json_encode($skillData);
