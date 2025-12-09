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
                <li><a href="index.php?protein=Poultry">Poultry</a></li>
                <li><a href="index.php?protein=Beef">Beef</a></li>
                <li><a href="index.php?protein=Pork">Pork</a></li>
                <li><a href="index.php?protein=Fish">Fish</a></li>
            </ul>
        </nav>

        <!--search bar-->
        <div class="search-container">
            <form method="GET" action="index.php">
                <!-- preserve protein filter when searching -->
                <input type="hidden" name="protein" value="<?php echo htmlspecialchars($protein_filter); ?>">
                <input type="text" name="query" placeholder="Search recipes..." class="search-bar" value="<?php echo htmlspecialchars($search_query); ?>">
                <button class="submit-btn">Submit</button>
            </form>
        </div>
    </header>