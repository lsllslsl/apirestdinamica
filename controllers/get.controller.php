<?php

require_once "models/get.model.php";

class GetController{

	/*==================================================================
	PETICIONES GET SIN FILTRO
	===================================================================*/

	static public function getData($table, $select, $orderBy, $orderMode,$startAt, $endAt){

		$response = GetModel::getData($table, $select, $orderBy, $orderMode,$startAt, $endAt);
	
		$return = new GetController();
		$return -> fncResponse($response);

	}

	/*==================================================================
	PETICIONES GET CON FILTRO
	===================================================================*/

	static public function getDataFilter($table, $select, $linkTo, $equalTo, $orderBy, $orderMode,$startAt, $endAt){
		
		$response = GetModel::getDataFilter($table, $select, $linkTo, $equalTo, $orderBy, $orderMode,$startAt, $endAt);
		
		$return = new GetController();
		$return -> fncResponse($response);

	}

	/*==================================================================
	PETICIONES GET SIN FILTRO ENTRE TABLAS RELACIONADAS
	===================================================================*/

	static public function getRelData($rel, $type, $select, $orderBy, $orderMode,$startAt, $endAt){

		$response = GetModel::getRelData($rel, $type, $select, $orderBy, $orderMode,$startAt, $endAt);

		$return = new GetController();
		$return -> fncResponse($response);

	

	}

	/*==================================================================
	PETICIONES GET CON FILTRO ENTRE TABLAS RELACIONADAS
	===================================================================*/

	static public function getRelDataFilter($rel, $type, $select,$linkTo, $equalTo, $orderBy, $orderMode,$startAt, $endAt){

		$response = GetModel::getRelDataFilter($rel, $type, $select,$linkTo, $equalTo, $orderBy, $orderMode,$startAt, $endAt);
	
		$return = new GetController();
		$return -> fncResponse($response);

	}




	//respuesta del controlador

	public function fncResponse($response){

		if(!empty($response)){

			$json = array(

				'status' => 200,
				'total' => count($response),
				'results' => $response

			);

		}else{

			$json = array(

				'status' => 404,
				'results' => 'Not Found'
			);

		}

		echo json_encode($json, http_response_code($json["status"]));

	}

}
?>