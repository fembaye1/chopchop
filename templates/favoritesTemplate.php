<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ChopChop - Favorites</title>
    <link rel="stylesheet" href="../styles/favorites.css" />
  </head>
  <body>
    <!-- Eyebrow Navigation -->
    <header class="header">
      <nav class="main-nav">
        <a class="logo" href="index.html">
          <img
            src="../assets/logo.svg"
            alt="ChopChop logo"
            width="36"
            height="36"
          />
          <span>ChopChop</span>
        </a>

        <!-- Main Nav -->
        <ul class="nav-links">
          <li><a href="./recipe-library">Recipe Library</a></li>
          <li><a class="active" href="#">Favorites</a></li>
          <li><a href="/shopping-list">Shopping List</a></li>
        </ul>

        <!-- Profile -->
        <a class="pfp" href="./profile.html">
          <img src="../assets/pfp.jpg" alt="Profile" width="36" height="36" />
        </a>
      </nav>
    </header>

    <!-- Main Content -->
    <main class="container">
      <!-- title header thing -->
      <section class="hero">
        <h1>Your Favorite Recipes</h1>
      </section>

      <!-- Page Control Buttons (will likely change to a popup or smth)-->
      <!-- Addresses filter and sort functionality -->
      <div class="controls">
        <button id="gridBtn">Grid</button>
        <button id="listBtn">List</button>
        <button id="filterBtn">Filter / Sort</button>
        <button id="addBtn">+ Add</button>
      </div>

      <!-- Grid View -->
      <section id="gridView" class="view">
        <div class="grid">
          <?php foreach ($favorites as $recipe): ?>
          <article class="card" data-id="1">
            <div class="card-top">
              <span class="dish"><?= htmlspecialchars($recipe['title']) ?></span>
              <button class="moreBtn">⋯</button>
            </div>
            <img src="<?= ($recipe['image_path'] ?: '../assets/food.jpg') ?>" alt="Thumbnail for <?= htmlspecialchars($recipe['title']) ?>" class="thumbnail" />
            <div class="card-body">
              <p class="quickDesc"><?= htmlspecialchars($recipe['genre']) ?> · <?= htmlspecialchars($recipe['time_takes']) ?> min</p>
            </div>
          </article>
          <?php endforeach; ?>
        </div>
      </section>

      <!-- List View -->
      <section id="listView" class="view hidden">
        <ul class="list">
          <?php foreach ($favorites as $recipe): ?>
          <li class="list-item">
            <img src="<?= htmlspecialchars($recipe['image_path'] ?: '../assets/food.jpg') ?>" alt="Thumbnail for <?= htmlspecialchars($recipe['title']) ?>" class="list-thumb" />
            <div class="list-content">
              <h3><?= htmlspecialchars($recipe['title']) ?></h3>
              <p><?= htmlspecialchars($recipe['genre']) ?> · <?= htmlspecialchars($recipe['time_takes']) ?> min</p>
            </div>
            <button class="moreBtn">⋯</button>
          </li>
          <?php endforeach; ?>
        </ul>
      </section>

      <!-- Recipe Actions Modal -->
      <!-- Addresses Recipe editing and detail viewing functionality -->
      <div id="recipeActions" class="modal hidden">
        <div class="modal-content">
          <h3>Recipe Actions</h3>
          <p>What would you like to do with this recipe?</p>
          <div class="modal-actions">
            <button id="openDetail" class="button">Open</button>
            <button id="editRecipe" class="button secondary">Edit</button>
            <button id="closeModal" class="button tertiary">Close</button>
          </div>
        </div>
      </div>

      <!-- Add Recipe Modal -->
      <!-- Addresses adding recipe to library functionality -->
      <!-- also handles user data entry -->
      <button id="addRecipeBtn" class="floating-add-btn">+</button>
      <div id="addRecipeModal" class="modal hidden">
          <div class="modal-content">
              <button id="closeAddModal" class="close-btn">×</button>
              <h3>Add New Recipe</h3>
              
              <form id="addRecipeForm" method="POST" enctype="multipart/form-data">
                  <input type="hidden" name="add_recipe" value="1">
                  
                  <label for="title">Recipe Title</label>
                  <input type="text" id="title" name="title" required>
                  
                  <label for="genre">Genre/Category</label>
                  <input type="text" id="genre" name="genre" required>
                  
                  <label for="time_takes">Cooking Time (minutes)</label>
                  <input type="number" id="time_takes" name="time_takes" required>
                  
                  <label for="instructions">Instructions</label>
                  <textarea id="instructions" name="instructions" required></textarea>
                  
                  <label for="image">Recipe Image (optional)</label>
                  <input type="file" id="image" name="image" accept="image/*">
                  
                  <label for="ingredient">Ingredient</label>
                  <input type="text" id="ingredient" name="ingredients[]" placeholder="e.g., flour">
                  
                  <label for="amount">Amount</label>
                  <input type="number" id="amount" name="amounts[]" placeholder="e.g., 2">
                  
                  <label for="unit">Unit</label>
                  <select id="unit" name="units[]">
                      <option value="lb">lb</option>
                      <option value="oz">oz</option>
                      <option value="ml">ml</option>
                  </select>

                  <div class="form-actions">
                      <button type="button" id="addIngredient" class="button secondary">
                          + Add Another Ingredient
                      </button>
                      <button type="submit" class="button">Save Recipe</button>
                  </div>
              </form>
              
              <!-- Display errors/success messages -->
              <?php if ($error): ?>
                  <div class="error-message"><?= htmlspecialchars($error) ?></div>
              <?php endif; ?>
              
              <?php if ($success): ?>
                  <div class="success-message"><?= htmlspecialchars($success) ?></div>
              <?php endif; ?>
          </div>
      </div>
      </div>
    </main>

    <!-- Footer -->
    <footer>
      <p>© ChopChop - Your Personal Recipe Library</p>
    </footer>

    <script>
      // View switching
      const gridView = document.getElementById("gridView");
      const listView = document.getElementById("listView");

      document.getElementById("gridBtn").onclick = () => showView(gridView);
      document.getElementById("listBtn").onclick = () => showView(listView);

      function showView(view) {
        gridView.classList.add("hidden");
        listView.classList.add("hidden");
        view.classList.remove("hidden");
      }

      // Recipe actions modal
      const recipeModal = document.getElementById("recipeActions");

      document.querySelectorAll(".moreBtn").forEach((btn) => {
        btn.onclick = () => {
          recipeModal.classList.remove("hidden");
        };
      });

      document.getElementById("closeModal").onclick = () => {
        recipeModal.classList.add("hidden");
      };

      // Add recipe modal
      const addModal = document.getElementById("addRecipeModal");
      const addForm = document.getElementById("addRecipeForm");

      // Open modal from both buttons
      document.getElementById("addRecipeBtn").onclick = openAddModal;
      document.getElementById("addBtn").onclick = openAddModal;

      function openAddModal() {
        addModal.classList.remove("hidden");
      }

      // Close modal
      document.getElementById("closeAddModal").onclick = () => {
        addModal.classList.add("hidden");
      };

      // Close when clicking outside modal
      addModal.onclick = (e) => {
        if (e.target === addModal) {
          addModal.classList.add("hidden");
        }
      };

      // Dynamic ingredient fields
      const ingredientFields = [];

      document.getElementById("addIngredient").onclick = () => {
        const ingredient = document.getElementById("ingredient").value;
        const amount = document.getElementById("amount").value;
        const unit = document.getElementById("unit").value;

        if (ingredient && amount) {
          // Store the ingredient data
          ingredientFields.push({ ingredient, amount, unit });
          
          // Show confirmation
          alert(`Added ${amount} ${unit} ${ingredient}`);
          
          // Clear the input fields
          document.getElementById("ingredient").value = "";
          document.getElementById("amount").value = "";
          document.getElementById("unit").selectedIndex = 0;
        } else {
          alert("Please fill in both ingredient and amount fields");
        }
      };

      // Note: Form submission is handled by PHP since we're not using e.preventDefault()
      // The form will submit normally to the server with all the data
    </script>
  </body>
</html>
