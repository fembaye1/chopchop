<?php
    class Recipe {
        private $pdo;

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }

        public function create($user_id, $title, $genre, $time_takes, $instructions, $ingredients = [], $image_path = null) {
            $ingredients_json = json_encode($ingredients);
            
            $stmt = $this->pdo->prepare("
                INSERT INTO chop_recipes (user_id, title, image_path, genre, time_takes, instructions, ingredients)
                VALUES (:user_id, :title, :image_path, :genre, :time_takes, :instructions, :ingredients)
            ");
            return $stmt->execute([
                'user_id' => $user_id,
                'title' => $title,
                'image_path' => $image_path,
                'genre' => $genre,
                'time_takes' => $time_takes,
                'instructions' => $instructions,
                'ingredients' => $ingredients_json
            ]);
        }

        public function findByUser($user_id) {
            $stmt = $this->pdo->prepare("
                SELECT * FROM chop_recipes 
                WHERE user_id = :user_id 
                ORDER BY created_at DESC
            ");
            $stmt->execute(['user_id' => $user_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function findById($id) {
            $stmt = $this->pdo->prepare("SELECT * FROM chop_recipes WHERE id = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function findAll() {
            $stmt = $this->pdo->prepare("SELECT * FROM chop_recipes ORDER BY created_at DESC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function search($query) {
            $searchTerm = '%' . $query . '%';
            $stmt = $this->pdo->prepare("
                SELECT * FROM chop_recipes 
                WHERE title LIKE :search 
                   OR genre LIKE :search 
                   OR instructions LIKE :search
                ORDER BY created_at DESC
            ");
            $stmt->execute(['search' => $searchTerm]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>