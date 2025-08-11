<?php
try {
    $pdo = new PDO(
        "mysql:host=localhost;port=3307;dbname=facture-dev",
        "root",
        "2349"
    );
    echo "Connexion OK";
} catch (PDOException $e) {
    echo "Erreur PDO: " . $e->getMessage();
}
