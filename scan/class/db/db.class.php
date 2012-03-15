<?php
class DB {
	
	private static $instance 	= 	NULL;	//Instance of class database
	public static $conn		=	NULL;	//Connection with the database
	
	//Create the instance
	private function __construct() {
		try {
			self::$conn = new PDO("mysql:host=localhost;dbname=nh5_sql", "nh5_kepas", "dswachtwoord");
			//self::$conn = new PDO("mysql:host=localhost;dbname=nh5_sql", "nh5", "andoorn4");
			
			//self::$conn = new PDO("mysql:host=localhost;dbname=nh5_sql", "root", "sunsation");
			return self::$conn;
		} catch (PDOException $e) {
			print("Error connection to database: ".$e->getMessage());
		}
	}
	
	//Calls the instance
	public static function getInstance() {
		if(self::$instance == NULL) {
			self::$instance = new DB;
		}
	}
	
	//Get the connection
	public static function getConn() {
		return self::$conn;
	}
}
DB::getInstance();
?>
