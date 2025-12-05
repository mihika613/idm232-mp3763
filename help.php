<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>No Results Found</title>

    <!--linking css stylesheets-->
    <link rel="stylesheet" href = "css/normalize.css">
    <link rel="stylesheet" href = "css/screen.css">
</head>
<body>
    
    <!--header-->
    <?php include 'header.php'; ?>

    <div class="help-directions">
        <h1>Need a Hand?</h1>
        <p>Welcome to the help page! Here's how you can make the most of Whip It Up:</p>
        <ul>
        <li>Use the <b>search bar</b> at the top to find specific recipes.</li>
        <li>Explore recipes by <b>category</b> in the navigation menu.</li>
        <li>Click any recipe card to see full details and instructions.</li>
        <li>If you can't find what you're looking for, check back soon - we're always adding more!</li>
        </ul>

        <button class="back-btn" onclick="history.back()">← Back</button>
    </div>

    <!--footer-->
    <?php include 'footer.php'; ?>
</body>
</html>