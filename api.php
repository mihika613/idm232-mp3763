<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once "db.php";   

$method   = $_SERVER['REQUEST_METHOD'];
$request  = $_GET['request'] ?? '';
$id       = $_GET['id'] ?? null;

$endpoint = explode('/', trim($request, '/'))[0] ?? '';

$table = "idm232_mp3763_data";

// routing
switch ($method) {

case 'GET':

    // GET /recipes (all recipes)
    if ($endpoint === 'recipes' && !$id) {

        $sql = "SELECT * FROM $table";
        $result = $connection->query($sql);

        $recipes = [];
        while ($row = $result->fetch_assoc()) {
            $recipes[] = $row;
        }

        echo json_encode($recipes);
        exit;
    }

    // GET /recipes?id=#
    if ($endpoint === 'recipes' && $id) {

        $statement = $connection->prepare("SELECT * FROM $table WHERE id = ?");
        $statement->bind_param("i", $id);
        $statement->execute();
        $recipe = $statement->get_result()->fetch_assoc();

        echo json_encode($recipe ?: null);
        exit;
    }

    http_response_code(404);
    echo json_encode(["error" => "Invalid GET endpoint"]);
    break;

default:
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
    break;
}
