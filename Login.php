<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "UnityBackend";

//Users Side script
$loginUser = $_POST["loginUser"] ;
$loginPassword = $_POST["loginPass"] ;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected Successfully , Active Users Details are here : ";

$sql = "SELECT password, level FROM users WHERE username = '". $loginUser . "'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
   if($row["password"] == $loginPassword )
   {
       echo "Login Success";
   }  
   else
   {
       echo "username and Password Wrong";
   }
}
} else {
  echo "0 results";
}
$conn->close();

?>