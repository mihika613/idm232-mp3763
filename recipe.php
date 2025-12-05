<?php
require_once "db.php";

$recipe_id      = isset($_GET['id']) ? intval($_GET['id']) : 0;
$search_query   = isset($_GET['query']) ? mysqli_real_escape_string($connection, $_GET['query']) : '';
$protein_filter = isset($_GET['protein']) ? $_GET['protein'] : 'All';

$is_search = false;
$results = null;
$recipe  = null;

if (!empty($search_query)) {
    $is_search = true;

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

    $results = mysqli_query($connection, $sql_query);
}

if (!$is_search) {
    if ($recipe_id > 0) {
        $sql_recipe = "SELECT * FROM idm232_mp3763_data WHERE id = $recipe_id LIMIT 1";
        $result_recipe = mysqli_query($connection, $sql_recipe);

        if ($result_recipe && mysqli_num_rows($result_recipe) > 0) {
            $recipe = mysqli_fetch_assoc($result_recipe);
        } else {
            // recipe not found -> go home
            mysqli_close($connection);
            header("Location: index.php");
            exit();
        }
    } else {
        // no id and not searching -> go home
        mysqli_close($connection);
        header("Location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if ($is_search): ?>
        <title>Search results for "<?php echo htmlspecialchars($search_query); ?>" | Whip It Up!</title>
    <?php else: ?>
        <title><?php echo htmlspecialchars($recipe['title']); ?> | Whip It Up!</title>
    <?php endif; ?>

    <!--linking css stylesheets-->
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/screen.css">
</head>
<body>

<!--header-->
<?php include 'header.php'; ?>

<?php if ($is_search): ?>
    <div class="page-container">
        <div class="intro">
            <h2>Search Results for</h2>
            <h1>"<?php echo htmlspecialchars($search_query); ?>"</h1>
            <h2>Here's what we found.</h2>
        </div>

        <div class="recipe-container">
            <?php 
            if ($results && mysqli_num_rows($results) > 0) {
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

        <?php mysqli_close($connection); ?>

        <!--footer-->
        <?php include 'footer.php'; ?>
    </div>

    <!-- Help Button -->
    <?php include 'help-button.php'; ?>

    <?php
    exit();
    ?>

<?php else: ?>
    <div class="section single-recipe-overview">
        <div class="recipe-text">
            <h1><?php echo htmlspecialchars($recipe['title']); ?></h1>
            <h3><?php echo htmlspecialchars($recipe['subtitle']); ?></h3>

            <div class="recipe-stats">
                <h5><?php echo htmlspecialchars($recipe['protein']); ?></h5>
                <h5><?php echo htmlspecialchars($recipe['servings']); ?> servings</h5>
                <h5>⏱ <?php echo htmlspecialchars($recipe['cook_time']); ?></h5>
                <h5><?php echo htmlspecialchars($recipe['calories']); ?> cal</h5>
            </div>

            <p><?php echo nl2br(($recipe['description'])); ?></p>

            <div class="divider">+ ° . ๑・° ⊹ . + ° . ๑・° ⊹ . + ° . ๑・° ⊹ . + ° . ๑・° ⊹ . + ° . ๑・° ⊹ . + ° . ๑・° ⊹ .</div>
        </div>

        <div class="recipe-image">
            <img src="<?php echo 'new_images/' . $recipe['id'] . '/' . htmlspecialchars($recipe['main_img']); ?>" alt="<?php echo htmlspecialchars($recipe['title']); ?>">
        </div>
    </div>
    
    <!--ingredients section-->
    <section>
        <div class="section-title">
            <h3>Ingredients</h3>
        </div>
    
        <div class="section ingredients">
            <img alt="ingredients image" src="<?php echo 'new_images/' . $recipe['id'] . '/' . htmlspecialchars($recipe['ingredients_img']); ?>">
            <div class="receipt">
                <h3>INGREDIENTS</h3>
                <?php
                    for ($i = 1; $i <= 13; $i++) {
                        $col = 'ingredient_#' . $i;
                        if (!empty($recipe[$col])) {
                            echo "<p>- " . htmlspecialchars($recipe[$col]) . "</p>";
                        }
                    }
                ?>
                <div class="receipt-footer">*** THANK YOU ***</div>
            </div>
        </div>
    </section>

    <!--instructions section-->
    <section>
        <div class="section-title">
            <h3>Instructions</h3>
        </div>

        <div class="section instructions-container">
            <?php
                for ($i = 1; $i <= 6; $i++) {
                    $titleCol = 'step_title_#' . $i;
                    $descCol  = 'step_desc_#' . $i;

                    if (!empty($recipe[$titleCol]) || !empty($recipe[$descCol])) {
                        echo '<div class="instructions">';
                        
                        if (!empty($recipe["step_imgs"])) {
                            $stepImages = explode('*', $recipe["step_imgs"]); 
                            if (isset($stepImages[$i - 1]) && !empty($stepImages[$i - 1])) {
                                echo '<img alt="step image" src="new_images/' . $recipe['id'] . '/' . htmlspecialchars($stepImages[$i - 1]) . '" width="400">';
                            } else {
                                echo '<img alt="recipe image" src="new_images/' . $recipe['id'] . '/' . htmlspecialchars($recipe['main_img']) . '" width="400">';
                            }
                        } else {
                            echo '<img alt="recipe image" src="new_images/' . $recipe['id'] . '/' . htmlspecialchars($recipe['main_img']) . '" width="400">';
                        }

                        echo '<h3>' . htmlspecialchars($recipe[$titleCol]) . '</h3>';
                        echo '<h4>' . nl2br(($recipe[$descCol])) . '</h4>';
                        echo '</div>';
                    }
                }
            ?>
        </div>
    </section>

    <?php
    // close connection for single recipe mode
    mysqli_close($connection); 
    ?>

    <!--footer-->
    <?php include 'footer.php'; ?>

    <!-- help button & linking js -->
    <?php include 'help-button.php'; ?>

<?php endif; ?>
</body>
</html>
