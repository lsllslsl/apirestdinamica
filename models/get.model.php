<?php

require_once "connection.php";

class GetModel{

	/*==================================================================
	PETICIONES GET SIN FILTRO
	===================================================================*/
	static public function getData($table, $select, $orderBy, $orderMode, $startAt, $endAt){

	echo '<pre>'. print_r(Connection::getColumnsData($table)). '</pre>';

	return;

	/*==================================================================
	Sin ordenar y limitar datos
	===================================================================*/

		$sql = "SELECT $select FROM $table";

	/*==================================================================
	ORDENAR DATOS SIN LIMITES
	===================================================================*/

		if ($orderBy != null && $orderMode != null && $startAt == null && $endAt == null) {
			
			$sql = "SELECT $select FROM $table ORDER BY $orderBy $orderMode";
		}

	/*==================================================================
	ORDENAR  Y LIMITAR DATOS
	===================================================================*/

		if ($orderBy != null && $orderMode != null && $startAt !=null && $endAt != null) {
			
			$sql = "SELECT $select FROM $table ORDER BY $orderBy $orderMode LIMIT $startAt, $endAt";

		}

	/*==================================================================
	LIMITAR DATOS SIN ORDENARLOS
	===================================================================*/

		if ($orderBy == null && $orderMode == null && $startAt !=null && $endAt != null) {
			
			$sql = "SELECT $select FROM $table LIMIT $startAt, $endAt";
		}

		$stmt = Connection::connect()->prepare($sql);
		
		$stmt -> execute();

		return $stmt -> fetchAll(PDO::FETCH_CLASS);
	}
	/*==================================================================
	PETICIONES GET CON FILTRO
	===================================================================*/

	static public function getDataFilter($table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt){

		$linkToArray = explode(",", $linkTo);
		$equalToArray = explode("_",$equalTo);
		$linkToText = "";

		if (count($linkToArray)>1) {
			
			foreach ($linkToArray as $key => $value) {
				
				if ($key > 0) {

					$linkToText .= "AND ".$value." = :".$value." ";

				}
			}
		}

	/*==================================================================
	Sin ordenar y limitar datos
	===================================================================*/

		$sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText";
	
	/*==================================================================
	ORDENAR DATOS SIN LIMITES
	===================================================================*/

	if ($orderBy != null && $orderMode != null && $startAt ==null && $endAt == null) {
					
			$sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText ORDER BY $orderBy $orderMode";
		}

	/*==================================================================
	ORDENAR  Y LIMITAR DATOS
	===================================================================*/

	if ($orderBy != null && $orderMode != null && $startAt !=null && $endAt != null) {
			
		$sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText ORDER BY $orderBy $orderMode LIMIT $startAt, $endAt";
	}

/*==================================================================
LIMITAR DATOS SIN ORDENARLOS
===================================================================*/

	if ($orderBy == null && $orderMode == null && $startAt !=null && $endAt != null) {
		
		$sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText LIMIT $startAt, $endAt";
	}

		$stmt = Connection::connect()->prepare($sql);

		foreach ($linkToArray as $key => $value) {
			
			$stmt -> bindParam(":".$value, $equalToArray[$key], PDO::PARAM_STR);
		}
		
		$stmt -> execute();

		return $stmt -> fetchAll(PDO::FETCH_CLASS);
	}

		/*==================================================================
		PETICIONES GET SIN FILTRO ENTRE TABLAS RELACIONADAS
		===================================================================*/
		static public function getRelData($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt){

		$relArray = explode(",", $rel);
		$typeArray = explode(",", $type);

		$innerJoinText = "";
		
		if (count($relArray)>1) {

			foreach ($relArray as $key => $value) {

				if ($key > 0) {

					$innerJoinText .= "INNER JOIN ".$value." ON ".$relArray[0].".id_".$typeArray[0]." =
						".$value.".id_".$typeArray[0]." ";
						
						// (relArray
						// 	[0] => tbl_records
						// 	[1] => tbl_documents
						// )
						// </pre>
						
						// <pre>Array
						// (typeArray
						// 	[0] => tbl_record
						// 	[1] => tbl_document
						// )
						// </pre>

						// SELECT * FROM tbl_records INNER JOIN tbl_documents ON tbl_records.id_tbl_document_tbl_record =
						// tbl_documents.id_tbl_document
				}
				
			}
	

			/*==================================================================
			Sin ordenar y sin limitar datos
			===================================================================*/
		
				$sql = "SELECT $select FROM $relArray[0] $innerJoinText";
		
			/*==================================================================
			ORDENAR DATOS SIN LIMITES
			===================================================================*/
		
				if ($orderBy != null && $orderMode != null && $startAt == null && $endAt == null) {
					
					$sql = "SELECT $select FROM $relArray[0] $innerJoinText ORDER BY $orderBy $orderMode";
				}
		
			/*==================================================================
			ORDENAR  Y LIMITAR DATOS
			===================================================================*/
		
				if ($orderBy != null && $orderMode != null && $startAt !=null && $endAt != null) {
					
					$sql = "SELECT $select FROM $relArray[0] $innerJoinText ORDER BY $orderBy $orderMode LIMIT $startAt, $endAt";
		
				}
		
			/*==================================================================
			LIMITAR DATOS SIN ORDENARLOS
			===================================================================*/
		
				if ($orderBy == null && $orderMode == null && $startAt !=null && $endAt != null) {
					
					$sql = "SELECT $select FROM $relArray[0] $innerJoinText LIMIT $startAt, $endAt";
				}
		
				$stmt = Connection::connect()->prepare($sql);
				
				$stmt -> execute();
		
				return $stmt -> fetchAll(PDO::FETCH_CLASS);
		} else {

			return null;
		}
	}














		/*==================================================================
		PETICIONES GET cON FILTRO ENTRE TABLAS RELACIONADAS
		===================================================================*/

	static public function getRelDataFilter($rel, $type, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt){

		/*==================================================================
		ORGANIZAMOS LOS FILTRO
		===================================================================*/
		$linkToArray = explode(",", $linkTo);
		$equalToArray = explode("_", $equalTo);
		$linkToText = "";

		if (count($linkToArray)>1) {

			foreach ($linkToArray as $key => $value) {

				if ($key > 0) {

					$linkToText .= "AND" .$value." = :".$value." ";
				}
				
			}

		}
		/*==================================================================
		ORGANIZAMOS LAS RELACIONES
		===================================================================*/

		$relArray = explode(",", $rel);
		$typeArray = explode(",", $type);
		
		$innerJoinText = "";
		
		if (count($relArray)>1) {

			foreach ($relArray as $key => $value) {

				if ($key > 0) {

					$innerJoinText .= "INNER JOIN ".$value." ON ".$relArray[0].".id_".$typeArray[0]." =
						".$relArray[1].".id_".$typeArray[1]." ";
				}
			
			}
			

			/*==================================================================
			Sin ordenar y sin limitar datos
			===================================================================*/
		
				$sql = "SELECT $select FROM $relArray[0] $innerJoinText WHERE $linkToArray[0] = :$linkToArray[0] $linkToText";

		
			/*==================================================================
			ORDENAR DATOS SIN LIMITES
			===================================================================*/
		
				if ($orderBy != null && $orderMode != null && $startAt == null && $endAt == null) {
					
					$sql = "SELECT $select FROM $relArray[0] $innerJoinText WHERE $linkToArray[0] = :$linkToArray[0] $linkToText 
						ORDER BY $orderBy $orderMode";
				}
			
		
			/*==================================================================
			ORDENAR  Y LIMITAR DATOS
			===================================================================*/
		
				if ($orderBy != null && $orderMode != null && $startAt !=null && $endAt != null) {
					
					$sql = "SELECT $select FROM $relArray[0] $innerJoinText  WHERE $linkToArray[0] = :$linkToArray[0] $linkToText 
						ORDER BY $orderBy $orderMode LIMIT $startAt, $endAt";
		
				}
		
			/*==================================================================
			LIMITAR DATOS SIN ORDENARLOS
			===================================================================*/
		
				if ($orderBy == null && $orderMode == null && $startAt !=null && $endAt != null) {
					
					$sql = "SELECT $select FROM $relArray[0] $innerJoinText WHERE $linkToArray[0] = :$linkToArray[0] $linkToText
					 LIMIT $startAt, $endAt";
				}
		
				$stmt = Connection::connect()->prepare($sql);

				foreach ($linkToArray as $key => $value) {
					
					$stmt -> bindParam(":".$value, $equalToArray[$key], PDO::PARAM_STR);
				}
				
				$stmt -> execute();
		
				return $stmt -> fetchAll(PDO::FETCH_CLASS);
		} else {

			return null;
		}
	}
}

?>


