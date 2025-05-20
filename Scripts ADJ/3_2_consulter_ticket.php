<?php
// Afficher les erreurs PHP pour déboguer
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    die("Accès refusé. Vous devez être connecté.");
}

// Inclut la connexion à la base de données
include 'db.php';

// Vérifie que l'ID est passé dans l'URL
$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID du ticket manquant.");
}

// Récupère les détails du ticket
$stmt = $bdd->prepare("SELECT t.*, e.libelle AS etat_libelle
                       FROM tickets t
                       JOIN etat e ON t.id_etat = e.id_etat
                       WHERE t.id = :id");
$stmt->execute(['id' => $id]);
$ticket = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$ticket) {
    die("Ticket introuvable.");
}

// Si le formulaire est soumis, on met à jour les informations du ticket
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupère les données du formulaire
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $probleme = $_POST['probleme'];
    $type_probleme = $_POST['type_de_probleme'];

    // Met à jour les informations du ticket
    $stmt = $bdd->prepare("UPDATE tickets SET nom = ?, email = ?, type_de_probleme = ?, probleme = ? WHERE id = ?");
    $stmt->execute([$nom, $email, $type_probleme, $probleme, $id]);


// Journalisation de la consultation d'un ticket
$stmt = $bdd->prepare("INSERT INTO logs (user_id, action) VALUES (?, ?)");
$action = "Consultation du ticket ID: " . $_GET['id'];
$stmt->execute([$_SESSION['user_id'] ?? 4, $action]);

    // Redirection après la modification
    header("Location: 3_2_consulter_ticket.php?id=$id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Consulter le ticket #<?= (int)$ticket['id'] ?></title>
</head>
<body>

<h1>Détail du ticket #<?= (int)$ticket['id'] ?></h1>

<form method="POST">
    <label for="nom">Nom :</label>
    <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($ticket['nom']) ?>" required><br>

    <label for="email">Email :</label>
    <input type="email" id="email" name="email" value="<?= htmlspecialchars($ticket['email']) ?>" required><br>

    <label>Type de problème :</label><br>
        <select name="type_de_probleme" required>
            <option value="">-- Sélectionner --</option>
            <option value="installation">Problème d'installation</option>
            <option value="connexion">Problème de connexion</option>
            <option value="bug">Bug logiciel</option>
            <option value="autre">Autre</option>
        </select><br>

    <label for="probleme">Problème :</label><br>
    <textarea id="probleme" name="probleme" rows="4" required><?= htmlspecialchars($ticket['probleme']) ?></textarea><br>

    <button type="submit">Modifier le ticket</button>
</form>

<form action="3_4_desactiver_ticket.php" method="POST" onsubmit="return confirm('Confirmer la fermeture du ticket ?');">
    <input type="hidden" name="ticket_id" value="<?php echo $ticket['id']; ?>">
    <button type="submit">Fermer</button>
</form>

            <!-- Formulaire pour changer l'état du ticket -->
            <form action="3_3_changer_etat.php" method="POST">
                <input type="hidden" name="id" value="<?= $ticket['id'] ?>">
                <select name="id_etat">
                    <option value="1" <?= $ticket['id_etat'] == 1 ? 'selected' : '' ?>>Ouvert</option>
                    <option value="2" <?= $ticket['id_etat'] == 2 ? 'selected' : '' ?>>En cours</option>
                    <option value="3" <?= $ticket['id_etat'] == 3 ? 'selected' : '' ?>>Fermé</option>
                </select>
                <button type="submit" class="changer-etat">Changer l'état</button>
            </form>

<p><a href="3_1_admin_tickets.php">Retour à l'administration</a></p>

</body>
</html>
