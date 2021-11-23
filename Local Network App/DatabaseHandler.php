<?php
/**
 * 
 */
class DatabaseHandler
{
	private $servername;
	private $username;
	private $password;
	private $conn;
	function __construct()
	{
		$this->servername = "localhost:3306";
		$this->username = "root";
		$this->password = "";
		$this->database = "test";
		$this->conn = new PDO("mysql:host=$this->servername;dbname=$this->database", $this->username, $this->password);
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	function execute_query($sql) {
		return $this->conn->query($sql);
	}

	function execute_update($sql) {
		return $this->conn->exec($sql);
	}

	function execute_update_prepared($sql) {
		$stmt = $this->conn->prepare($sql); 
		$stmt->execute();
		return $stmt;
	}

	function fetch_data($result) {
		$result->setFetchMode(PDO::FETCH_ASSOC);
		return $result->fetch();
	}

}
