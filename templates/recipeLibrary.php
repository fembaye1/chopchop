<!DOCTYPE html>
<html>
  <head>
    <meta name="utf-8" />
    <meta name="description" content="Welcome to ChopChop!" />
    <link rel="stylesheet" href="/chop/styles/index.css" />
    <title>ChopChop - Recipe Library</title>
  </head>
  <body>
    <!-- Header -->
    <header class="header">
      <nav class="main-nav">
        <a class="logo" href="index.html">
          <img
            src="/chop/assets/logo.svg"
            alt="ChopChop logo"
            width="36"
            height="36"
          />
          <span>ChopChop</span>
        </a>

        <!-- Main Navigation -->
        <ul class="nav-links">
          <li>
            <a class="active" href="/chop/recipe-library">Recipe Library</a>
          </li>
          <li><a href="/chop/index.php?url=favorites">Favorites</a></li>
          <li><a href="/chop/index.php?url=shopping-list">Shopping List</a></li>
        </ul>

        <!-- Profile -->
        <a class="pfp" href="/chop/profile.php">
          <img src="/chop/assets/pfp.jpg" alt="Profile" width="36" height="36" />
        </a>
      </nav>
    </header>

    <!-- Main Content -->
    <main class="recipe-main">
      <div class="page-header">
        <h1>Recipe Library</h1>
        <p>Discover amazing recipes for every occasion</p>

        <!-- Search Bar where they can look up different recipes -->
        <div class="search-container">
          <input
            type="text"
            id="searchInput"
            placeholder="Search recipes..."
            class="search-input"
          />
          <button class="search-btn">Search</button>
        </div>
      </div>

      <!-- Recipe Cards to show what it would look like for meals-->
      <div class="recipes-grid">
        <?php foreach ($recipes as $recipe): ?>
        <div class="recipe-card">
          <img
            src="<?= (htmlspecialchars($recipe['image_path']) ?: '../assets/food.jpg') ?>"
            alt="<?= htmlspecialchars($recipe['title']) ?> recipe"
            class="recipe-image"
          />
          <div class="recipe-content">
            <h3><?= htmlspecialchars($recipe['title']) ?></h3>
            <div class="recipe-meta">
              <span class="cooking-time"><?= htmlspecialchars($recipe['time_takes']) ?> min</span>
              <span class="genre"><?= htmlspecialchars($recipe['genre']) ?></span>
            </div>
            <button class="view-recipe-btn">View Recipe</button>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </main>

    <!-- Footer -->
    <footer>
      <p>(c) ChopChop - Your Personal Recipe Library</p>
    </footer>
  </body>
</html>
