<?php

$routesArray = explode("/",$_SERVER['REQUEST_URI']);
 //echo '<pre>'; print_r($_SERVER['REQUEST_URI']); echo '</pre>';
// echo '<pre>'; print_r($routesArray); echo '</pre>';
// return;
$routesArray = array_filter($routesArray);

/*============================================
Cuando no se hace ninguna petición a la API
=============================================*/

if(count($routesArray) == 1){

	$json = array(

		'status' => 404,
		'results' => 'Not Found'

	);

	echo json_encode($json, http_response_code($json["status"]));

	return;

}

/*=============================================
Cuando si se hace una petición a la API
=============================================*/

if(count($routesArray) == 2 && isset($_SERVER['REQUEST_METHOD'])){

	$table = explode("?", $routesArray[2][0]);

	/*=============================================
	Peticiones GET
	=============================================*/

	if($_SERVER['REQUEST_METHOD'] == "GET"){

		include "services/get.php";

	}

	/*=============================================
	Peticiones POST
	=============================================*/

	if($_SERVER['REQUEST_METHOD'] == "POST"){

		include "services/post.php";

	}

	/*=============================================
	Peticiones PUT
	=============================================*/

	if($_SERVER['REQUEST_METHOD'] == "PUT"){

		include "services/put.php";

	}

	/*=============================================
	Peticiones DELETE
	=============================================*/

	if($_SERVER['REQUEST_METHOD'] == "DELETE"){

		include "services/delete.php";

	}

}