<?php

require_once("connection.php");

class PostModel
{

    static public function postData($table, $data)
    {

        $columns = "";
        $params = "";

        foreach ($data as $key => $value) {
            $columns .= $key . ",";
            $params .= ":" . $key . ",";
        }

        $columns = substr($columns, 0, -1);
        $params  = substr($params, 0, -1);

        $sql = "INSERT INTO $table($columns) VALUES ($params)";

        $stmt = Connection::connect()->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindParam(":" . $key, $value, PDO::PARAM_STR);
        }

        if ($stmt->execute()) {
            $response = array(
                "Comment" => "El proceso se ejecutó correctamente"
            );

            return $response;
        } else {
            return Connection::connect()->errorInfo();
        }
    }
}
