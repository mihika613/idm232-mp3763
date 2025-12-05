<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Whip It Up!</title>

    <!--linking css stylesheets-->
    <link rel="stylesheet" href = "css/normalize.css">
    <link rel="stylesheet" href = "css/screen.css">
</head>
<body>
    <div class="page-container">

        <?php
        require_once "db.php";

        $protein_filter = isset($_GET['protein']) ? $_GET['protein'] : 'All';
        $search_query   = isset($_GET['query']) ? mysqli_real_escape_string($connection, $_GET['query']) : '';

        $protein_map = [
            'Poultry'     => ["Chicken", "Turkey"],
            'Beef'        => ["Beef", "Steak"],
            'Vegetarian'  => ["Vegetarian"],
            'Pork'        => ["Pork"],
            'Fish'        => ["Fish"]
        ];
        
        if (array_key_exists($protein_filter, $protein_map)) {
            $protein_list = implode("','", $protein_map[$protein_filter]);
            $protein_condition = "protein IN ('$protein_list')";
        } else if ($protein_filter === "All") {
            $protein_condition = "1"; 
        } else {
            $protein_condition = "protein = '" . mysqli_real_escape_string($connection, $protein_filter) . "'";
        }
        
        if (!empty($search_query)) {
            $sql_query = "
                SELECT * FROM idm232_mp3763_data
                WHERE $protein_condition
                  AND (
                        title LIKE '%$search_query%' OR
                        description LIKE '%$search_query%' OR
                        all_ingredients LIKE '%$search_query%' OR
                        protein LIKE '%$search_query%'
                      )
            ";
        } else {
            $sql_query = "
                SELECT * FROM idm232_mp3763_data
                WHERE $protein_condition
            ";
        }
        
        $results = mysqli_query($connection, $sql_query);
        ?>

        <!--header-->
        <?php include 'header.php'; ?>

        <div class="intro">
            <?php if (!empty($search_query)) { ?>
                <h2>Search Results for</h2>
                <h1>"<?php echo htmlspecialchars($search_query); ?>"</h1>
                <h2>Here's what we found.</h2>

            <?php } else if ($protein_filter !== 'All') { 
                $pretty_name = $protein_filter;
            ?>
                <h2>Whip It Up's</h2>
                <h1><?php echo htmlspecialchars($pretty_name); ?> Recipes</h1>
                <h2>Classic comfort with a flavorful twist.</h2>

            <?php } else { ?>
                <h2>Welcome to</h2>
                <h1>Whip It Up!</h1>
                <h2>Roll up your sleeves - your next favorite recipe awaits.</h2>
            <?php } ?>
        </div>


        <div class="recipe-container">
        <?php 
        if (mysqli_num_rows($results) > 0) {
            while ($recipe = mysqli_fetch_assoc($results)) {
            include "recipe-card.php";
            }
        } else { ?>
            <div class="no-results">
                <h2>Sorry! We couldn't find any results for "<?php echo htmlspecialchars($search_query); ?>"</h2>
                <p>Try searching something else or adjusting your filter.</p>
            </div>
        <?php } ?>
        </div>

        <?php
        mysqli_close($connection); 
        ?>

        <!--footer-->
        <?php include 'footer.php'; ?>
    </div>

    <!-- help button & linking js -->
    <?php include 'help-button.php'; ?>

</body>
</html>