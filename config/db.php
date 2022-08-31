<?php 
class db
{
    private $conn;
 
	public function __construct()
	{      
		$servername = "localhost";
		$username = "root";
		$password = "";
	    $database="slim-api";   
		$this->conn = mysqli_connect($servername, $username, $password,$database);
	}
	public function getConnection()
	{
		return $this->conn;
	}
}
?>