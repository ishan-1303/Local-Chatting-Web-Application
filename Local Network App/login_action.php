<?php 
  require 'DatabaseHandler.php';
	if (isset($_POST['login'])) 
	{
		$db = new DatabaseHandler();

		$uid = $_POST['username'];
		$pwd = $_POST['pass'];

		try 
		{
		    
		    $sql = "SELECT id,email_id,password FROM login WHERE email_id = '$uid' AND password = '$pwd'";
		    
		    $result = $db->execute_update_prepared($sql);
		
			$rows = $result->fetchAll(); // assuming $result == true

			$n = count($rows);
			if ($n > 0)
			{
				//echo "LOGIN SUCCESSFULL";

				session_start();

				$_SESSION['email_id'] = $uid;
				$_SESSION['time']     = time();
				$_SESSION['id'] = $rows[0]['id'];
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