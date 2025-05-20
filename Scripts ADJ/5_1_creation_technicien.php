<?php
session_start();
include 'db.php'; // contient la connexion PDO via $bdd

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérifie que le nom d'utilisateur n'existe pas déjà
    $stmt = $bdd->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        die("Nom d'utilisateur déjà utilisé.");
    }

    // Hash du mot de passe (chiffrement sécurisé)
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Insertion dans la base
    $stmt = $bdd->prepare("INSERT INTO users (username, password_hash, role) VALUES (?, ?, 'technicien')");
    $stmt->execute([$username, $password_hash]);
    
 // Journalisation de la création d'un compte technicien
$stmt = $bdd->prepare("INSERT INTO logs (user_id, action) VALUES (?, ?)");
$action = "Création d'un compte technicien avec le nom d'utilisateur: " . $_POST['username'];
$stmt->execute([$_SESSION['user_id'] ?? 4, $action]);


    echo "Technicien créé avec succès.";
}
?>

<form method="POST">
    <label>Nom d'utilisateur : <input type="text" name="username" required></label><br>
    <label>Mot de passe : <input type="password" name="password" required></label><br>
    <input type="submit" value="Créer le compte technicien">
</form>

    <ul>
        <li><a href="index.php">home</a></li>
    </ul>