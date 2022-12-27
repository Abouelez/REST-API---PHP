<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$category = new Category($db);
$category->id = $_GET['id'] ?? die();


$category->readSingle();

$arr = array(
    'id' => $category->id,
    'name' => $category->name
);

echo json_encode($arr);
