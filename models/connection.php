<?php

use FTP\Connection as FTPConnection;

require_once "get.model.php";

class Connection{

	/*=============================================
	Información de la base de datos
	=============================================*/

	static public function infoDatabase(){

		$infoDB = array(

			"database" => "lexa",
			"user" => "root",
			"pass" => ""

		);

		return $infoDB;

	}

	/*=============================================
	Conexión a la base de datos
	=============================================*/

	static public function connect(){


		try{

			$link = new PDO(
				"mysql:host=localhost;dbname=".Connection::infoDatabase()["database"],
				Connection::infoDatabase()["user"], 
				Connection::infoDatabase()["pass"]
			);

			$link->exec("set names utf8");

		}catch(PDOException $e){

			die("Error: ".$e->getMessage());

		}

		return $link;

	}

	static public function getColumnsData($table, $columns)
	{
		$db = Connection::infoDatabase()["database"];

		$validate = Connection::connect()
		->query("SELECT COLUMN_NAME AS item FROM information_schema.columns WHERE table_schema = '$db' AND table_name = '$table'")
		->fetchAll(PDO::FETCH_OBJ);

		if (empty($validate)) {
			return null;
		}else{

			$sum = 0;

			foreach($validate as $key => $value)
			{
				$sum += in_array($value->item, $columns);
			}

			return $sum == count($columns) ? $validate : null;
		}
	}

	
}

?>