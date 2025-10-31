<?php
    class Favorite {
        private $pdo;

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }

        public function addFavorite($user_id, $recipe_id) {
            $stmt = $this->pdo->prepare("
                INSERT INTO chop_favorites (user_id, recipe_id)
                VALUES (:user_id, :recipe_id)
            ");
            return $stmt->execute([
                'user_id' => $user_id,
                'recipe_id' => $recipe_id
            ]);
        }

        public function removeFavorite($user_id, $recipe_id) {
            $stmt = $this->pdo->prepare("
                DELETE FROM chop_favorites 
                WHERE user_id = :user_id AND recipe_id = :recipe_id
            ");
            return $stmt->execute([
                'user_id' => $user_id,
                'recipe_id' => $recipe_id
            ]);
        }

        public function getFavoritesByUser($user_id) {
            $stmt = $this->pdo->prepare("
                SELECT r.* 
                FROM chop_recipes r 
                JOIN chop_favorites f ON r.id = f.recipe_id 
                WHERE f.user_id = :user_id
            ");
            $stmt->execute(['user_id' => $user_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function isFavorited($user_id, $recipe_id) {
            $stmt = $this->pdo->prepare("
                SELECT COUNT(*) FROM chop_favorites 
                WHERE user_id = :user_id AND recipe_id = :recipe_id
            ");
            $stmt->execute(['user_id' => $user_id, 'recipe_id' => $recipe_id]);
            return $stmt->fetchColumn() > 0;
        }
    }
?>