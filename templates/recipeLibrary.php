<!DOCTYPE html>
<html>
  <head>
    <meta name="utf-8" />
    <meta name="description" content="Welcome to ChopChop!" />
    <link rel="stylesheet" href="../styles/index.css" />
    <title>ChopChop - Recipe Library</title>
  </head>
  <body>
    <!-- Header -->
    <header class="header">
      <nav class="main-nav">
        <a class="logo" href="index.html">
          <img
            src="assets/logo.svg"
            alt="ChopChop logo"
            width="36"
            height="36"
          />
          <span>ChopChop</span>
        </a>

        <!-- Main Navigation -->
        <ul class="nav-links">
          <li>
            <a class="active" href="./recipeLibrary.html">Recipe Library</a>
          </li>
          <li><a href="./favorites.html">Favorites</a></li>
          <li><a href="./shoppingList.html">Shopping List</a></li>
        </ul>

        <!-- Profile -->
        <a class="pfp" href="./profile.html">
          <img src="assets/pfp.jpg" alt="Profile" width="36" height="36" />
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
        <!-- Recipe Card 1 -->
        <div class="recipe-card">
          <img
            src="assets/food.jpg"
            alt="Spaghetti Carbonara"
            class="recipe-image"
          />
          <div class="recipe-content">
            <h3>Spaghetti Carbonara</h3>
            <p class="recipe-description">
              Classic Italian pasta with eggs, cheese, and pancetta
            </p>
            <div class="recipe-meta">
              <span class="cooking-time">20 min</span>
              <span class="difficulty">Easy</span>
            </div>
            <button class="view-recipe-btn">View Recipe</button>
          </div>
        </div>

        <!-- Recipe Card 2 -->
        <div class="recipe-card">
          <img
            src="assets/food.jpg"
            alt="Chicken Stir Fry"
            class="recipe-image"
          />
          <div class="recipe-content">
            <h3>Chicken Stir Fry</h3>
            <p class="recipe-description">
              Quick and healthy Asian-inspired chicken with vegetables
            </p>
            <div class="recipe-meta">
              <span class="cooking-time">15 min</span>
              <span class="difficulty">Easy</span>
            </div>
            <button class="view-recipe-btn">View Recipe</button>
          </div>
        </div>

        <!-- Recipe Card 3 -->
        <div class="recipe-card">
          <img
            src="assets/food.jpg"
            alt="Chocolate Chip Cookies"
            class="recipe-image"
          />
          <div class="recipe-content">
            <h3>Chocolate Chip Cookies</h3>
            <p class="recipe-description">
              Soft and chewy homemade cookies perfect for dessert
            </p>
            <div class="recipe-meta">
              <span class="cooking-time">30 min</span>
              <span class="difficulty">Medium</span>
            </div>
            <button class="view-recipe-btn">View Recipe</button>
          </div>
        </div>

        <!-- Recipe Card 4 -->
        <div class="recipe-card">
          <img src="assets/food.jpg" alt="Caesar Salad" class="recipe-image" />
          <div class="recipe-content">
            <h3>Caesar Salad</h3>
            <p class="recipe-description">
              Fresh romaine lettuce with homemade Caesar dressing
            </p>
            <div class="recipe-meta">
              <span class="cooking-time">10 min</span>
              <span class="difficulty">Easy</span>
            </div>
            <button class="view-recipe-btn">View Recipe</button>
          </div>
        </div>

        <!-- Recipe Card 5 -->
        <div class="recipe-card">
          <img src="assets/food.jpg" alt="Beef Tacos" class="recipe-image" />
          <div class="recipe-content">
            <h3>Beef Tacos</h3>
            <p class="recipe-description">
              Seasoned ground beef with fresh toppings in crispy shells
            </p>
            <div class="recipe-meta">
              <span class="cooking-time">25 min</span>
              <span class="difficulty">Easy</span>
            </div>
            <button class="view-recipe-btn">View Recipe</button>
          </div>
        </div>

        <!-- Recipe Card 6 -->
        <div class="recipe-card">
          <img
            src="assets/food.jpg"
            alt="Vegetable Soup"
            class="recipe-image"
          />
          <div class="recipe-content">
            <h3>Vegetable Soup</h3>
            <p class="recipe-description">
              Hearty soup packed with seasonal vegetables
            </p>
            <div class="recipe-meta">
              <span class="cooking-time">45 min</span>
              <span class="difficulty">Easy</span>
            </div>
            <button class="view-recipe-btn">View Recipe</button>
          </div>
        </div>
      </div>
    </main>

    <!-- Footer -->
    <footer>
      <p>(c) ChopChop - Your Personal Recipe Library</p>
    </footer>
  </body>
</html>
