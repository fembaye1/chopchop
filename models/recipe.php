<?php
class Recipe {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllRecipes() {
        $stmt = $this->pdo->query("SELECT * FROM recipes ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecipeById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM recipes WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addRecipe($user_id, $title, $instructions) {
        $stmt = $this->pdo->prepare("
            INSERT INTO recipes (user_id, title, instructions)
            VALUES (:user_id, :title, :instructions)
        ");
        $stmt->execute([
            'user_id' => $user_id,
            'title' => $title,
            'instructions' => $instructions
        ]);
    }
}
?>