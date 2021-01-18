  

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
    
    .fill-width 
      {
        width: 500px;
      }
      .fill
      {
        width: 60px;
      }
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height: auto;} 
    }
  </style>
</head>
<body>


<div id = "rel">

<?php 
      session_start();
      $uid = $_SESSION['email_id'];
      //echo $uid;
      try
      {
        $servername = "localhost:3307";
        $username = "root";
        $password = "";
        $conn = new PDO("mysql:host=$servername;dbname=test", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Connected successfully"; 

        $sql = "SELECT username,fname,lname,message,date FROM chat ORDER BY id DESC";
        
        $q = $conn->query($sql);
        $q->setFetchMode(PDO::FETCH_ASSOC);
       
        while($result = $q->fetch())
        {
            $eid = $result['username'];
            $fn = $result['fname'];
            $ln = $result['lname'];
            $msg = $result['message'];
            $time = $result['date'];

            $sql2 = "SELECT profile from login WHERE email_id='$eid'";
            $q2 = $conn->query($sql2);
            $q2->setFetchMode(PDO::FETCH_ASSOC);
            $result2 = $q2->fetch();

            $path = $result2['profile'];
            

            echo "
                  <div class=\"col-sm-9\">
                   <h3> <img src=\"" . $path . "\"  width=\"40\" height=\"40\"> " . $fn . " ". $ln . "</h3>
                  <p>  " . $msg . "</p>
                  <h5><span class=\"glyphicon glyphicon-time\"></span> $time</h5>
                  <hr></div> 
                 ";
        }
      }
      catch(PDOException $e)
      {
          echo "Connection failed: " . $e->getMessage();
      }
?>
</div>
</body>
</html>
