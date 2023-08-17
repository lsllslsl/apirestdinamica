<?php

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

	
}

?>