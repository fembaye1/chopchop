<?php
    //front controller
    require_once __DIR__ . '/db.php';
    require_once __DIR__ . '/models/Recipe.php';
    require_once __DIR__ . '/models/Favorite.php';
    require_once __DIR__ . '/models/User.php';

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
            if (isset($_SESSION['user_id'])) {
                header('Location: /chop/index.php?url=recipe-library');
                exit();
            }
            include 'templates/home.php';
            break;

        case 'recipe-library':
            if (!isset($_SESSION['user_id'])) {
                header('Location: /chop/index.php?url=home');
                exit();
            }

            $search = $_GET['search'] ?? '';
            $recipes = $search
                ? $recipeModel->search($search)
                : $recipeModel->findAll();

            include 'templates/recipeLibrary.php';
            break;

    case 'favorites':
        // Check authentication
        if (!isset($_SESSION['user_id'])) {
            header('Location: /chop/index.php?url=home');
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
                // Handle image upload
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
                        $favorites = $favoriteModel->getFavoritesByUser($user_id); // Refresh
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
            header('Location: /chop/index.php?url=home');
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
                header('Location: /chop/index.php?url=recipe-library');
                exit();
            } else {
                $error = "Invalid email or password.";
                include 'templates/home.php';
            }
        } else {
            header('Location: /chop/index.php?url=home');
            exit();
        }
        break;

    case 'register':
        // Show registration form
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            include 'templates/register.php';
        }
        // Handle registration form submission
        elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $confirm_password = trim($_POST['confirm_password']);
            
            // Validation
            if (empty($username) || empty($email) || empty($password)) {
                $error = "All fields are required.";
                include 'templates/register.php';
            } elseif ($password !== $confirm_password) {
                $error = "Passwords do not match.";
                include 'templates/register.php';
            } elseif ($userModel->findByEmail($email)) {
                $error = "Email already registered.";
                include 'templates/register.php';
            } else {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                if ($userModel->create($username, $email, $password_hash)) {
                    // Auto-login after registration
                    $user = $userModel->findByEmail($email);
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    header('Location: /chop/index.php?url=recipe-library');
                    exit();
                } else {
                    $error = "Registration failed. Please try again.";
                    include 'templates/register.php';
                }
            }
        }
        break;

    case 'logout':
        session_destroy();
        header('Location: /chop/index.php?url=home');
        exit();
        break;

    default:
        header('Location: /chop/index.php?url=home');
        exit();
        break;
    }
?>