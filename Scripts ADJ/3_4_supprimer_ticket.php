<?php
session_start();

//Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    die("Accès refusé. Vous devez être connecté.");
}
try {
include 'db.php'; // Connexion à la base de données via $bdd

// Récupère le ticket_id depuis le formulaire (POST)
$ticket_id = $_POST['ticket_id'];

// Préparer la requête SQL avec un paramètre nommé :ticket_id
$sql = "UPDATE support.tickets SET affichage = 0 WHERE id = :ticket_id";

// Préparer la requête avec la variable $bdd
$stmt = $bdd->prepare($sql);

// Lier le paramètre :ticket_id avec la valeur de $ticket_id
$stmt->bindValue(':ticket_id', $ticket_id, PDO::PARAM_INT);

// Exécuter la requête
$stmt->execute();

// Journalisation de la fermeture du ticket
$stmt = $bdd->prepare("INSERT INTO logs (user_id, action) VALUES (?, ?)");
$action = "Fermeture du ticket ID: " . $_POST['ticket_id'];
$stmt->execute([$_SESSION['user_id'] ?? 4, $action]);


// Redirection vers la page de gestion des tickets
header("Location: 3_1_admin_tickets.php");

} catch (PDOException $e) {
    echo 'Erreur : ' . $e->getMessage();
}
?>