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
	      $sql = "SELECT fname,lname,country,dob,active,profile FROM login WHERE email_id = '$uid'";
		    
	      $q = $db->execute_query($sql);
        $result = $db->fetch_data($q);

			$fn = $result['fname'];
			$ln = $result['lname'];
      $dob = $result['dob'];
      $active = $result['active'];
      $profile = $result['profile'];
      $country = $result['country'];

			//echo $profile;

		}

		//echo "WELCOME " . $fn . " " . $ln;
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

   <script type="text/javascript">
     
    function showpost()
    {
      $("#posts").load("chatself.php");
      var elem = document.getElementById('emp');
      elem.parentNode.removeChild(elem);
      return false;
    }

    
   </script>
</head>
<body>

  

<div class="jumbotron text-center">
	  <h1>  <?php echo  " " . $fn . " " . $ln ?></h1>
</div>


<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav" name = "search">
      <h4><?php echo " " . $fn . " " . $ln ?></h4>
      <ul class="nav nav-pills nav-stacked">
        <li class="active"><a href="profile.php">Profile</a></li>
        <li class="active"><a href="Home2.php">Home</a></li>
        <li><a href="#" id="friends">Friends</a></li>
        <li class="active"><a href="javascript:showpost()" id = "post">Your Posts</a></li>
        
      </ul><br>

    </div>

    <div class="col-sm-3" >
      <img src="<?php echo "" . $profile ?>" alt="Italian Trulli" style="width:325px;height:400px;">
      <br> <br>
       <form action="upload.php" method="post" enctype="multipart/form-data">
          <input type="file" name="fileToUpload" id="fileToUpload">
          <input type="submit" value="Upload Image" name="submit">
        </form>
    </div>

    <div class="col-sm-2" id = "emp">
        <h3> Date of Birth: </h3>
        <h3> Country:</h3>
        <h3> Friends:   </h3>
    </div>

     <div class="col-sm-4" id = "posts">
        <h3> <?php echo  " " . $dob ?></h3>
        <h3> <?php echo  " " . $country ?></h3>
        <h3> <?php echo  "0"  ?> </h3>
    </div>
  
  </div>
</div>

<button id="lo" name="lo" > <a href="logout.php"> LOG OUT </a></button>

<footer class="container-fluid" >
  <p>Footer Text</p>
</footer>

</body>
</html>
