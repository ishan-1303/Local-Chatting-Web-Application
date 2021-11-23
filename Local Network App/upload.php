<?php
  require 'DatabaseHandler.php';
$target_dir = "profile_pictures/";
$target_file = basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
session_start();
$uid = $_SESSION['email_id'];
$id = $_SESSION['id'];

echo $id;
$path = $target_dir . "" . $id . "/" . $target_file;
$path2 = $target_dir . "" . $id;
mkdir("" . $path2, 0777,true);
move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $path);

$path = $target_dir . "" . $id . "/" . $target_file;

$db = new DatabaseHandler();

$sql = "UPDATE login SET profile='$path' WHERE email_id='$uid'";
              // use exec() because no results are returned
$db->execute_update($sql);
echo "New record created successfully";

header('Location: profile.php');
	exit;
?>