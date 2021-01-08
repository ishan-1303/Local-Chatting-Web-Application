<?php 
	if (isset($_POST['login'])) 
	{
		
		$servername = "localhost:3307";
		$username = "root";
		$password = "";
		$uid = $_POST['username'];
		$pwd = $_POST['pass'];

		try 
		{
		    $conn = new PDO("mysql:host=$servername;dbname=test", $username, $password);
		    // set the PDO error mode to exception
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    //echo "Connected successfully"; 

		    $sql = "SELECT email_id,password FROM login WHERE email_id = '$uid' AND password = '$pwd'";
		    
		    $stmt = $conn->prepare($sql); 
			$result = $stmt->execute();
		
			$rows = $stmt->fetchAll(); // assuming $result == true

			$n = count($rows);
			//echo "" . $n;


			if ($n > 0)
			{
				//echo "LOGIN SUCCESSFULL";

				session_start();

				$_SESSION['email_id'] = $uid;
				$_SESSION['time']     = time();
				//echo $_SESSION['email_id'];
				//echo "<script> window.location.assign('home.php'); </script>";
				header("Location: home2.php");
				exit();
			}
			else
			{
				echo "LOGIN FAILED";
			}
		}
		catch(PDOException $e)
		{
		    echo "Connection failed: " . $e->getMessage();
		}
	}

?>