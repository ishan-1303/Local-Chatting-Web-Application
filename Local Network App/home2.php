	<?php
		session_start();
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
			$servername = "localhost:3307";
			$username = "root";
			$password = "";
			$conn = new PDO("mysql:host=$servername;dbname=test", $username, $password);
		    // set the PDO error mode to exception
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    //echo "Connected successfully"; 

		    $sql = "SELECT fname,lname FROM login WHERE email_id = '$uid'";
		    
		    $q = $conn->query($sql);
			$q->setFetchMode(PDO::FETCH_ASSOC);
			$result = $q->fetch();

			$fn = $result['fname'];
			$ln = $result['lname'];

			$sql = "SELECT fname,lname FROM login WHERE email_id NOT IN('$uid')";
			$q = $conn->query($sql);
			$q->setFetchMode(PDO::FETCH_ASSOC);
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
  <script src="Scripts/jquery-1.10.2.js"></script>
	  <script type="text/javascript">
	        $(function () 
	        {
	            $("#posts").load("chat2.php");
	        });
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
        if(isset($_POST['send']))
        {
          sendfun();
        }

        function sendfun()
        {
          try
          {
            $msg = trim($_POST['msgtext']);

            $time = date("Y-m-d H:i:s");
            if(empty($msg))
            {
                echo "msg empty";
            }
            else
            {
              $uid = $_SESSION['email_id'];
              $servername = "localhost:3307";
              $username = "root";
              $password = "";
              $conn = new PDO("mysql:host=$servername;dbname=test", $username, $password);
              // set the PDO error mode to exception
              $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

              $sql = "SELECT fname,lname FROM login WHERE email_id = '$uid'";
              $q = $conn->query($sql);
              $q->setFetchMode(PDO::FETCH_ASSOC);
              $result = $q->fetch();

              $fn = $result['fname'];
              $ln = $result['lname'];

              $sql = "INSERT INTO chat(username,fname,lname,message,date) VALUES ('$uid', '$fn', '$ln', '$msg', CURRENT_TIME())";
              // use exec() because no results are returned
              $conn->exec($sql);
              echo "New record created successfully";
            }
          }
           catch(PDOException $e)
          {
            echo "Connection failed: " . $e->getMessage();
          }
        }
      ?>
</body>
</html>
