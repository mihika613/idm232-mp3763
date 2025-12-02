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


        if (!empty($search_query)) {
            if ($protein_filter === 'All') {
                $sql_query = "
                    SELECT * FROM idm232_mp3763_data
                    WHERE title LIKE '%$search_query%'
                       OR description LIKE '%$search_query%'
                       OR all_ingredients LIKE '%$search_query%'
                       OR protein LIKE '%$search_query%'
                ";
            } else {
                $sql_query = "
                    SELECT * FROM idm232_mp3763_data
                    WHERE protein = '$protein_filter'
                      AND (
                            title LIKE '%$search_query%' OR
                            description LIKE '%$search_query%' OR
                            all_ingredients LIKE '%$search_query%' OR
                            protein LIKE '%$search_query%'
                          )
                ";
            }
        } else {
            if ($protein_filter === 'All') {
                $sql_query = "SELECT * FROM idm232_mp3763_data";
            } else {
                $sql_query = "
                    SELECT * FROM idm232_mp3763_data
                    WHERE protein = '$protein_filter'
                ";
            }
        }
        
        $results = mysqli_query($connection, $sql_query);
        ?>


        <!--menu-->
        <header>
            <!--logo-->
            <h2 class="logo"><a href="index.php">Whip It Up!</a></h2>

            <!--nav options-->
            <input type="checkbox" id="nav-toggle" class="nav-toggle" hidden>
            <label for="nav-toggle" class="nav-toggle-label">
                <span></span>
                <span></span>
                <span></span>
            </label>
            <nav>
                <ul>
                    <li><a href="index.php?protein=All">All</a></li>
                    <li><a href="index.php?protein=Vegetarian">Vegetarian</a></li>
                    <li><a href="index.php?protein=Chicken">Chicken</a></li>
                    <li><a href="index.php?protein=Beef">Beef</a></li>
                    <li><a href="index.php?protein=Fish">Fish</a></li>
                    <li><a href="index.php?protein=Turkey">Turkey</a></li>
                    <li><a href="index.php?protein=Steak">Steak</a></li>
                </ul>
            </nav>


            <!--search bar-->
            <div class="search-container">
                <form method="GET">
                    <input type="textbox" name="query" placeholder="Search recipes..." class="search-bar">
                    <button class="submit-btn">Submit</button>
                </form>
            </div>
        </header>

        <div class="intro">
            <?php if (!empty($search_query)) { ?>
                <h2>Search Results for</h2>
                <h1>"<?php echo htmlspecialchars($search_query); ?>"</h1>
                <h2>Here's what we found.</h2>

            <?php } else if ($protein_filter !== 'All') { ?>
                <h2>Whip It Up's</h2>
                <h1><?php echo htmlspecialchars($protein_filter); ?> Recipes</h1>
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
        <section class="footer">
            <h3>© Created by Mihika</h3>
        </section>
    </div>

    <!-- Help Button -->
    <button class="help-button" id="helpBtn" title="Need Help?">?</button> 

    <script src="main.js"></script>

</body>
</html>