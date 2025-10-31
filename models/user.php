<?php
    class User {
        private $pdo;

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }

        public function findById($id) {
            $stmt = $this->pdo->prepare("SELECT * FROM chop_users WHERE id = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function findByEmail($email) {
            $stmt = $this->pdo->prepare("SELECT * FROM chop_users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function create($username, $email, $password_hash) {
            $stmt = $this->pdo->prepare("
                INSERT INTO chop_users (username, email, password_hash) 
                VALUES (:username, :email, :password_hash)
            ");
            return $stmt->execute([
                'username' => $username,
                'email' => $email,
                'password_hash' => $password_hash
            ]);
        }
    }
?>