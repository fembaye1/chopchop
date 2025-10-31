<?php
    require_once 'db.php';
    require_once 'models/Recipe.php';
    require_once 'models/Favorite.php';
    require_once 'models/User.php';

    session_start();

    // Get the requested URL
    $url = $_GET['url'] ?? 'home';
    $url = rtrim($url, '/');
    $urlParts = explode('/', $url);

    $page = $urlParts[0] ?? 'home';
    $action = $urlParts[1] ?? 'index';
    $id = $urlParts[2] ?? null;

    // Initialize models
    $recipeModel = new Recipe($pdo);
    $favoriteModel = new Favorite($pdo);
    $userModel = new User($pdo);

    // route handling
    switch ($page) {
        case 'home':
            // If user is logged in, redirect to recipe library
            if (isset($_SESSION['user_id'])) {
                header('Location: /recipe-library');
                exit();
            }
            // If not logged in, show the login/home page
            include 'templates/home.php';
            break;

        case 'recipe-library':
        // Check authentication
        if (!isset($_SESSION['user_id'])) {
            header('Location: /home');
            exit();
        }

        $user_id = $_SESSION['user_id'];
        $search = $_GET['search'] ?? '';
        
        if ($search) {
            $recipes = $recipeModel->search($search);
        } else {
            $recipes = $recipeModel->findAll();
        }
        include 'templates/recipeLibrary.php';
        break;

    case 'favorites':
        // Check authentication
        if (!isset($_SESSION['user_id'])) {
            header('Location: /home');
            exit();
        }

        $user_id = $_SESSION['user_id'];
        $favorites = $favoriteModel->getFavoritesByUser($user_id);
        
        // Handle recipe creation from the modal
        $error = '';
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_recipe'])) {
            $title = trim($_POST['title']);
            $genre = trim($_POST['genre']);
            $time_takes = intval($_POST['time_takes']);
            $instructions = trim($_POST['instructions']);
            $ingredients = $_POST['ingredients'] ?? [];

            if (empty($title) || empty($genre) || empty($instructions)) {
                $error = "Please fill in all required fields.";
            } elseif ($time_takes <= 0) {
                $error = "Cooking time must be a positive number.";
            } else {
                $image_path = null;
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = "uploads/";
                    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                    $filename = uniqid() . "_" . basename($_FILES['image']['name']);
                    $targetPath = $uploadDir . $filename;
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                        $image_path = $targetPath;
                    } else {
                        $error = "Image upload failed.";
                    }
                }

                if (empty($error)) {
                    if ($recipeModel->create($user_id, $title, $genre, $time_takes, $instructions, $ingredients, $image_path)) {
                        $success = "Recipe added successfully!";
                        // Refresh the favorites list
                        $favorites = $favoriteModel->getFavoritesByUser($user_id);
                    } else {
                        $error = "Failed to add recipe.";
                    }
                }
            }
        }
        
        include 'templates/favoritesTemplate.php';
        break;

    case 'shopping-list':
        // Check authentication
        if (!isset($_SESSION['user_id'])) {
            header('Location: /home');
            exit();
        }

        // shopping list logic will come later...
        include 'templates/shoppingList.php';
        break;

    case 'login':
        // Handle login form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            
            $user = $userModel->findByEmail($email);
            
            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header('Location: /recipe-library');
                exit();
            } else {
                $error = "Invalid email or password.";
                include 'templates/home.php';
            }
        } else {
            header('Location: /home');
            exit();
        }
        break;

    case 'logout':
        session_destroy();
        header('Location: /home');
        exit();
        break;

    default:
        header('Location: /home');
        exit();
        break;
    }
?>