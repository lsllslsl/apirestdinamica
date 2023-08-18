<?php

require_once("models/post.model.php");

class PostController
{

    public static function postData($table, $data)
    {

        $response = PostModel::postData($table, $data);
        echo '<pre>'; print_r($response); echo '</pre>';
        return;
    }
}
