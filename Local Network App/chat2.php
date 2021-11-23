  

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
    // $(function() {
    //     setInterval(doRefresh, 1000);
    // });
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

<form action = "home2.php" method = "post" enctype="multipart/form-data">
        <div class="col-sm-9">
          <input type = "text" name = "msgtext"  class="fill-width" placeholder="type here">
          <button type="submit" name="send"  class="fill"> Post </button>
          <input type="file" name="fileToUpload" id="fileToUpload" accept="image/png, image/gif, image/jpeg">
        </div>
    </form>
<div id = "rel">

<?php 
 require 'DatabaseHandler.php';
      session_start();
      $uid = $_SESSION['email_id'];
      //echo $uid;
      try
      {
        
        $db = new DatabaseHandler();

        $sql = "SELECT id,username,fname,lname,message,date, image, `like` FROM chat ORDER BY id DESC";
        
        $q = $db->execute_query($sql);

        while($result = $db->fetch_data($q))
        {
            $eid = $result['username'];
            $fn = $result['fname'];
            $ln = $result['lname'];
            $msg = $result['message'];
            $time = $result['date'];
            $image = $result['image'];
            $likeCount = $result['like'];
            $id = $result['id'];

            $sql2 = "SELECT profile from login WHERE email_id='$eid'";
            $q2 = $db->execute_query($sql2);
            $result2 = $db->fetch_data($q2);

            $path = $result2['profile'];
            #echo $path;
            echo "<div class=\"col-sm-9\">";
            echo "<h3> <img src=\"" . $path . "\"  width=\"40\" height=\"40\"> " . $fn . " ". $ln . "</h3>";
            if($image != "" || $image != NULL) {
              echo "<img src=\"" . $image . "\" width=\"400\">";
            }
            echo "<p>  " . $msg . "</p>";

            echo "<h5><span class=\"glyphicon glyphicon-time\"></span> $time</h5>";

          echo "<label><a href=\"home2.php?like=" . $likeCount . "&post_id=" . $id . "\"> <input type=\"radio\" name=\"reaction\" value=\"Like!\" > " . $likeCount . " Like! </a></label>";
            echo "<hr></div> ";
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
