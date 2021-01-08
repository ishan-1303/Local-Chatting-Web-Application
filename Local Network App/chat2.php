  

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <script type="text/javascript">
    function doRefresh(){
        $("#rel").load("chat.php");
    }
    $(function() {
        setInterval(doRefresh, 1000);
    });
</script>
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

<form action = "home2.php" method = "post" >
        <div class="col-sm-9">
          <input type = "text" name = "msgtext"  class="fill-width" placeholder="type here">
          <button type="submit" name="send"  class="fill"> Post </button>
          
        </div>
    </form>
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
            // if($uid == $eid)
            // {
            //     $c = "container1 darker";
            //     $t = "time-right";
            //     $msgp = "msgr";
            // }
            // else
            // {
            //     $c = "container1";
            //     $t = "time-left";
            //     $msgp = "msgl";
            // }

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
 
<!-- <div class="container-fluid">
  <div class="row content">
    

    <div class="col-sm-9">
      <h4><small>RECENT POSTS</small></h4>
      <hr>
      <h2>I Love Food</h2>
      <h5><span class="glyphicon glyphicon-time"></span> Post by Jane Dane, Sep 27, 2015.</h5>
      <h5><span class="label label-danger">Food</span> <span class="label label-primary">Ipsum</span></h5><br>
      <p>Food is my passion. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
      <br><br>
      
      <h4><small>RECENT POSTS</small></h4>
      <hr>
      <h2>Officially Blogging</h2>
      <h5><span class="glyphicon glyphicon-time"></span> Post by John Doe, Sep 24, 2015.</h5>
      <h5><span class="label label-success">Lorem</span></h5><br>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
      <hr>

     
      
     
    </div>
  </div>
</div>

<footer class="container-fluid">
  <p>Footer Text</p>
</footer> -->

</body>
</html>
