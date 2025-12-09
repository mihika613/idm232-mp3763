<?php
require_once "db.php";

// read and sanitize inputs
$protein_filter = isset($_GET['protein']) ? $_GET['protein'] : 'All';
$search_query   = isset($_GET['query']) ? $_GET['query'] : '';

$protein_map = [
    'Poultry'     => ["Chicken", "Turkey"],
    'Beef'        => ["Beef", "Steak"],
    'Vegetarian'  => ["Vegetarian"],
    'Pork'        => ["Pork"],
    'Fish'        => ["Fish"]
];

// build protein condition 
if (array_key_exists($protein_filter, $protein_map)) {
    $protein_list = implode("','", $protein_map[$protein_filter]);
    $protein_condition = "protein IN ('$protein_list')";
} else if ($protein_filter === "All") {
    $protein_condition = "1";
} else {
    $protein_condition = "protein = '" . mysqli_real_escape_string($connection, $protein_filter) . "'";
}

// search through all text-fields from database
$text_search = "
    title LIKE ? OR
    subtitle LIKE ? OR
    description LIKE ? OR
    cook_time LIKE ? OR
    servings LIKE ? OR
    calories LIKE ? OR
    protein LIKE ? OR
    all_ingredients LIKE ? OR
    all_steps LIKE ? OR
    `ingredient_#1` LIKE ? OR
    `ingredient_#2` LIKE ? OR
    `ingredient_#3` LIKE ? OR
    `ingredient_#4` LIKE ? OR
    `ingredient_#5` LIKE ? OR
    `ingredient_#6` LIKE ? OR
    `ingredient_#7` LIKE ? OR
    `ingredient_#8` LIKE ? OR
    `ingredient_#9` LIKE ? OR
    `ingredient_#10` LIKE ? OR
    `ingredient_#11` LIKE ? OR
    `ingredient_#12` LIKE ? OR
    `ingredient_#13` LIKE ? OR
    `step_title_#1` LIKE ? OR
    `step_desc_#1` LIKE ? OR
    `step_title_#2` LIKE ? OR
    `step_desc_#2` LIKE ? OR
    `step_title_#3` LIKE ? OR
    `step_desc_#3` LIKE ? OR
    `step_title_#4` LIKE ? OR
    `step_desc_#4` LIKE ? OR
    `step_title_#5` LIKE ? OR
    `step_desc_#5` LIKE ? OR
    `step_title_#6` LIKE ? OR
    `step_desc_#6` LIKE ? OR
    how_to_name LIKE ? OR
    `how_to/history_desc` LIKE ?
";


// final SQL
if (!empty($search_query)) {

    $sql_query = "
        SELECT * 
        FROM idm232_mp3763_data
        WHERE $protein_condition
        AND (
            $text_search
        )
    ";

    $is_search = true;

    // prepared statement start
    $stmt = $connection->prepare($sql_query);

    // build the bound parameter (same for all LIKE fields)
    $param = "%{$search_query}%";

    // create an array with 36 copies because there are 36 fields in text_search
    $params = array_fill(0, 36, $param);

    // generate the types string: 36 strings => "ssssss..."
    $types = str_repeat("s", 36);

    // bind dynamically
    $stmt->bind_param($types, ...$params);

    $stmt->execute();
    $results = $stmt->get_result();

} else {

    $is_search = false;

    $sql_query = "
        SELECT * 
        FROM idm232_mp3763_data
        WHERE $protein_condition
    ";

    // simple prepared statement (no search params)
    $stmt = $connection->prepare($sql_query);
    $stmt->execute();
    $results = $stmt->get_result();
}
?>