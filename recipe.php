<!--search-->
<?php include "search.php"; 

$recipe_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$is_search) {
    if ($recipe_id > 0) {
        $stmt_recipe = $connection->prepare("SELECT * FROM idm232_mp3763_data WHERE id = ? LIMIT 1");
        $stmt_recipe->bind_param("i", $recipe_id);
        $stmt_recipe->execute();
        $result_recipe = $stmt_recipe->get_result();

    if ($result_recipe && $result_recipe->num_rows > 0) {
        $recipe = $result_recipe->fetch_assoc();
    } else {
        mysqli_close($connection);
        header("Location: index.php");
        exit();
    }
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
                    <?php include "no-results.php"; ?>
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
