<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$category = new Category($db);
$category->id = $_GET['id'] ?? die();

$result = $category->getPosts();



$data = $result->fetchAll(PDO::FETCH_ASSOC);

if (empty($data)) {
    $data['Message'] = "No Categories Found!";
}

print_r(json_encode($data));
