	<?php
  require 'DatabaseHandler.php';

		session_start();
    $db = new DatabaseHandler();

		$uid = $_SESSION['email_id'];

		if(empty($uid))
		{
				header("HTTP/1.0 404 Not Found");
				echo "<h1>404 Not Found</h1>";
				echo "The page that you have requested could not be found.";
				exit();
		}
		else
		{

	    $sql = "SELECT fname,lname FROM login WHERE email_id = '$uid'";
		    
	    $result = $db->execute_query($sql);
			$result = $db->fetch_data($result);

			$fn = $result['fname'];
			$ln = $result['lname'];

			// $sql = "SELECT fname,lname FROM login WHERE email_id NOT IN('$uid')";
			// $q = $conn->query($sql);
			// $q->setFetchMode(PDO::FETCH_ASSOC);

      if (isset($_GET['like'])) {
        echo "here" . $_GET['like']++;
        $sql = "UPDATE chat SET `like`='" . $_GET['like']. "' WHERE id=" . $_GET['post_id'];
        $db->execute_update($sql);
      }        
        
		}
    if(isset($_POST['send']))
        {
          @sendfun();
        }

        function sendfun()
        {
          try
          {
            $db = new DatabaseHandler();
            $msg = trim($_POST['msgtext']);
            $target_file = basename($_FILES["fileToUpload"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            
            $id = $_SESSION['id'];

            $path = $_FILES['fileToUpload']['name'];
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $target_dir = "media/";
            $path = $target_dir . "" . $id . "/" . $target_file;
            $path2 = $target_dir . "" . $id;
            mkdir("" . $path2, 0777,true);
            #echo $extension;
            if(empty($msg) && (empty($target_file)  || (strcasecmp($extension ,'jpg') == 1 && strcasecmp($extension ,'jpeg') == 1 && strcasecmp($extension ,'png') == 1 && strcasecmp($extension ,'gif') == 1)))
            {
                echo "no msg or image";
            }
            else
            {
              move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $path);
              $path = $target_dir . "" . $id . "/" . $target_file;
              $numbers = mt_rand(1,1000000000);
              rename($path, $path2 . "/image" . $numbers . ".jpg");
              
              $path = str_replace($path, $path2 . "/image" . $numbers . ".jpg", $path);
              $time = date("Y-m-d H:i:s");
              $uid = $_SESSION['email_id'];
              $id = $_SESSION['id'];

              $sql = "SELECT fname,lname FROM login WHERE email_id = '$uid'";
              $q = $db->execute_query($sql);
              $result = $db->fetch_data($q);

              $fn = $result['fname'];
              $ln = $result['lname'];
              if(!empty($target_file)) {                
                $sql = "INSERT INTO chat(username,fname,lname,message,image,date) VALUES ('$uid', '$fn', '$ln', '$msg', '$path',CURRENT_TIME())";
              
              // use exec() because no results are returned
                $db->execute_update($sql);
              }
              else {
                $sql = "INSERT INTO chat(username,fname,lname,message,date) VALUES ('$uid', '$fn', '$ln', '$msg',CURRENT_TIME())";
              
              // use exec() because no results are returned
                $db->execute_update($sql);
              }
              echo "New record created successfully";
            }
          }
           catch(PDOException $e)
          {
            echo "Connection failed: " . $e->getMessage();
          }
        }
	?>




<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <style>
    /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
    .row.content {height: 1500px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height: auto;} 
    }

    #lo
	  	{
	  		position: absolute;
			top: 10px;
			right: 10px;
	  	}
    
  </style>
  <script src="Scripts/jquery-1.10.2.js"></script>
	  <script type="text/javascript">
	        $(function () 
	        {
	            $("#posts").load("chat2.php");
	        });
          if ( window.history.replaceState ) {
              window.history.replaceState( null, null, window.location.href );
          }
	  </script>
</head>
<body>
<div class="jumbotron text-center">
	  <h1>WELCOME <?php echo " " . $fn . " " . $ln ?></h1>
</div>


<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav">
      <h4><?php echo " " . $fn . " " . $ln ?></h4>
      <ul class="nav nav-pills nav-stacked">
        <li class="active"><a href="profile.php">Profile</a></li>
        <li><a href="#section2">Friends</a></li>
      </ul><br>
      
    </div>

    <div class="col-sm-9" id="posts">
      </div>
  </div>
</div>

<button id="lo" name="lo" > <a href="logout.php"> LOG OUT </a></button>
	
	<?php
        
      ?>
</body>
</html>
