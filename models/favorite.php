<?php
class Favorite {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addFavorite($user_id, $recipe_id) {
        $stmt = $this->pdo->prepare("
            INSERT INTO favorites (user_id, recipe_id)
            VALUES (:user_id, :recipe_id)
        ");
        $stmt->execute([
            'user_id' => $user_id,
            'recipe_id' => $recipe_id
        ]);
    }

    public function getFavoritesByUser($user_id) {
        $stmt = $this->pdo->prepare("
            SELECT r.* 
            FROM recipes r 
            JOIN favorites f ON r.id = f.recipe_id 
            WHERE f.user_id = :user_id
        ");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>