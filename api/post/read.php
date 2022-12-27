<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

$database = new Database();
$db = $database->connect();

$post = new Post($db);

$result = $post->read();

$length = $result->rowCount();

if ($length) {
    $posts_arr = array();
    //$posts_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $post_item = array(
            'id' => $id,
            'title' => $title,
            'body' => $body,
            'author' => $author,
            'category_name' => $category_name,
            'category_id' => $category_id
        );
        $posts_arr[] = $post_item;
    }

    //Turn into JSON & output
    echo json_encode($posts_arr);
} else {
    echo json_encode(
        array('message' => 'No posts found')
    );
}
