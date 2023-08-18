<?php

require_once "controllers/get.controller.php";

 $table = explode("?", $routesArray[2])[0];

 $select = $_GET["select"] ??  "*";
 $orderBy = $_GET["orderBy"] ??  null;
 $orderMode = $_GET["orderMode"] ??  null;
 $startAt = $_GET["startAt"] ?? null;
 $endAt = $_GET["endAt"] ?? null;


 $response = new GetController();

 /*==================================================================
	PETICIONES GET CON FILTRO
	===================================================================*/


 if (isset($_GET["linkTo"]) && isset($_GET["equalTo"]) && !isset($_GET["rel"]) && !isset($_GET["type"])) {

    $response -> getDataFilter($table, $select, $_GET["linkTo"], $_GET["equalTo"],$orderBy, $orderMode, $startAt, $endAt);
 
	 /*==================================================================
	PETICIONES GET SIN FILTRO ENTRE TABLAS RELACIONADAS
	===================================================================*/

}elseif (isset($_GET["rel"]) && isset($_GET["type"]) && $table == "relations" && !isset($_GET["linkTo"]) && !isset($_GET["equalTo"])) {
	
	$response -> getRelData($_GET["rel"], $_GET["type"], $select, $orderBy, $orderMode,$startAt, $endAt);
 
 
  /*==================================================================
	PETICIONES GET SIN FILTRO ENTRE TABLAS RELACIONADAS
	===================================================================*/
	
}elseif (isset($_GET["rel"]) && isset($_GET["type"]) && $table == "relations" && isset($_GET["linkTo"]) && isset($_GET["equalTo"])) {
	
	$response -> getRelDataFilter($_GET["rel"], $_GET["type"], $select,  $_GET["linkTo"], $_GET["equalTo"], $orderBy, $orderMode,$startAt, $endAt);


 /*==================================================================
	PETICIONES GET PARA EL BUSCADOR SIN RELACIONES
 ===================================================================*/
	
}elseif (!isset($_GET["rel"]) && !isset($_GET["type"]) && isset($_GET["linkTo"]) && isset($_GET["search"])) {
	
	$response -> getDataSearch($table, $select, $_GET["linkTo"], $_GET["search"], $orderBy, $orderMode, $startAt, $endAt);


 /*==================================================================
	PETICIONES GET PARA EL BUSCADOR con RELACIONES
 ===================================================================*/

}elseif (isset($_GET["rel"]) && isset($_GET["type"]) && $table == "relations" && isset($_GET["linkTo"]) && isset($_GET["search"])) {

	$response -> getRelDataSearch($_GET["rel"], $_GET["type"], $select,  $_GET["linkTo"], $_GET["search"], $orderBy, $orderMode,$startAt, $endAt);

}
else{

   /*==================================================================
	PETICIONES GET SIN FILTRO
	===================================================================*/

    $response -> getData($table, $select, $orderBy, $orderMode,$startAt, $endAt);

 }
