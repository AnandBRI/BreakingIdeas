<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "UnityBackend";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT itemID FROM useritems WHERE userID = 2";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
   $rows = array();
    while($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
   // echo json_decode($rows);
} else {
  echo "0 ";
}
$conn->close();

?>