<?php
session_start();

include_once 'object/Customer.php';

if (isset($_GET['cid'])) {
    $user = new User();
    $user->deleteFromCity($_GET['cid']);
} else if (isset($_GET['aid'])) {
    $user = new User();
    $user->deleteFromArea($_GET['aid']);
}
header('location:addCityAreaFront.php');
