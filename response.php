// update_timeout.php

<?php
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'];

    // Update the database with "timeout" in the 'sisa_waktu' column
    $updateQuery = "UPDATE data_user SET sisa_waktu = 'timeout' WHERE id = $userId";
    $result = mysqli_query($conn, $updateQuery);
}
?>