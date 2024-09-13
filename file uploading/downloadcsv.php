<?php
include("newconnection.php");

$query = "SELECT * FROM csv";
$result = mysqli_query($con, $query);

$fileDetails = array();
while ($row = mysqli_fetch_assoc($result)) {
    $files[] = array("name" => $row['name'], "path" => $row['path']);
}


echo json_encode($fileDetails);
?>

