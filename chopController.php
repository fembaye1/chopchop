<?php
require_once "schema.php";
require_once "models/recipe.php";
require_once "models/favorite.php";

$pdo = new PDO('pgsql:host=localhost;dbname=cs4640_yournetid', 'yournetid', 'yourpassword');
$controller = $_GET['action'] ?? 'home';

$recipeModel = new Recipe($pdo);
$favoriteModel = new Favorite($pdo);

switch ($controller) {
    case 'viewRecipes':
        $recipes = $recipeModel->getAllRecipes();
        include "templates/recipeLibrary.php";
        break;

    case 'addFavorite':
        $favoriteModel->addFavorite($_SESSION['user_id'], $_GET['recipe_id']);
        header("Location: ?action=viewFavorites");
        break;

    case 'viewFavorites':
        $favorites = $favoriteModel->getFavoritesByUser($_SESSION['user_id']);
        include "templates/favorites.php";
        break;

    default:
        include "templates/homeView.php";
}

?>