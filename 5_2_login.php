<?php
session_start();
include 'db.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Préparation de la requête SQL sans guillemets autour du paramètre
    $stmt = $bdd->prepare("SELECT id, password_hash, role FROM users WHERE username = :username");

    // Lier le paramètre :username
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);

    // Exécuter la requête
    $stmt->execute();

    // Récupérer l'utilisateur
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérification du mot de passe
    if ($user && password_verify($password, $user['password_hash'])) {
        // Authentification réussie
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        // Journalisation de la connexion
$stmt = $bdd->prepare("INSERT INTO logs (user_id, action) VALUES (?, ?)");
$stmt->execute([$_SESSION['user_id'] ?? 4, "Connexion réussie de l'utilisateur '$username'"]);


       header("Location: 6_1_menu_technicien.php");
      exit;
    } else {
        echo "Identifiants incorrects.";
    }
}
?>

<form method="POST">
    <label>Nom d'utilisateur : <input type="text" name="username" required></label><br>
    <label>Mot de passe : <input type="password" name="password" required></label><br>
    <input type="submit" value="Se connecter">
</form>

<ul>
        <li><a href="index.php">home</a></li>
</ul>