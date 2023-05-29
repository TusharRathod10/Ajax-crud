<?php
$con = mysqli_connect('localhost', 'root', '', 'ajax') or die('Connection failed');


if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $fetch_user = json_encode(mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM crud WHERE `id`='$id'")));
    print_r($fetch_user);
}

