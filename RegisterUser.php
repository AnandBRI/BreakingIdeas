<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "UnityBackend";

//Users Side
$loginUser = $_POST["loginUser"] ;
$loginPassword = $_POST["loginPass"] ;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) 
  {
   die("Connection failed: " . $conn->connect_error);
  }
  else{
echo "Connected Successfully , Active Users Details are here : ";
     }
$sql = "SELECT username FROM users WHERE username = '". $loginUser . "'";
$result = $conn->query($sql);

if ($result->num_rows > 0)
 {
  echo "username is already taken";
 } else {
  echo "creatingUser...";
}
  $sql2 = "INSERT INTO users (username, password) VALUES('". $loginUser . "','". $loginPassword . "')";
 if ($conn->query($sql2) === TRUE)
  {
    echo "new Record Created Sucessfully";
  }
    else 
    {
      echo "Error : " . $sql . "<br>" . $conn->error;
    }
$conn->close();

?>