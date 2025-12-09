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
        
        <!--search-->
        <?php include "search.php"; ?>

        <!--header-->
        <?php include 'header.php'; ?>

        <div class="intro">
            <?php if (!empty($search_query)) { ?>
                <h2>Search Results for</h2>
                <h1>"<?php echo htmlspecialchars($search_query); ?>"</h1>

            <?php if ($protein_filter !== 'All') : ?>
                <p class="filter-indicator">Filter applied: <?php echo htmlspecialchars($protein_filter); ?></p>
            <?php endif; ?>

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
                    <?php include "no-results.php"; ?>
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