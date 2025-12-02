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
                <li><a href="index.php">All</a></li>
                <li><a href="vegetarian.php">Vegetarian</a></li>
                <li><a href="chicken.php">Chicken</a></li>
                <li><a href="beef.php">Beef</a></li>
                <li><a href="fish.php">Fish</a></li>
                <li><a href="turkey.php">Turkey</a></li>
                <li><a href="steak.php">Steak</a></li>
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
    <section class="footer">
        <h3>© Created by Mihika</h3>
    </section>


</body>
</html>