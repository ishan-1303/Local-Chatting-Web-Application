<?php
$target_dir = "profile_pictures/";
$target_file = basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
session_start();
$uid = $_SESSION['email_id'];

$path = $target_dir . "" . $uid . "/" . $target_file;
$path2 = $target_dir . "" . $uid;
mkdir("" . $path2, 0777,true);
move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $path);






$path = $target_dir . "" . $uid . "/" . $target_file;


$servername = "localhost:3307";
$username = "root";
$password = "";
$conn = new PDO("mysql:host=$servername;dbname=test", $username, $password);
// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "UPDATE login SET profile='$path' WHERE email_id='$uid'";
              // use exec() because no results are returned
$conn->exec($sql);
echo "New record created successfully";

header('Location: profile.php');
	exit;
?>