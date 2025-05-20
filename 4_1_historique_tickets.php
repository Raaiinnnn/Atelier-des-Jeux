<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    die("Accès refusé. Vous devez être connecté.");
}

// Inclut la connexion à la base de données
require_once 'db.php';

// Récupère tous les tickets et leurs états
try {

    // Journalisation de l'accès à la page historique des tickets
$stmt = $bdd->prepare("INSERT INTO logs (user_id, action) VALUES (?, ?)");
$action = "Accès à la page historique des tickets";
$stmt->execute([$_SESSION['user_id'] ?? 4, $action]);

    $stmt = $bdd->query("SELECT t.*, e.libelle AS etat_libelle
                         FROM tickets t 
                         JOIN etat e ON t.id_etat = e.id_etat
                         WHERE t.affichage = 0
                         ORDER BY t.date_creation DESC;");
    $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des tickets : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique tickets</title>
    <style>
        /* Styles de base pour les tickets */
        .ticket {
            margin: 10px;
            padding: 10px;
            border: 1px solid #ddd;
        }
        .ouvert {
            background-color:rgb(169, 235, 115);
        }
        .en_cours {
            background-color:rgb(245, 244, 180);
        }
        .fermé {
            background-color:rgb(241, 86, 80)
        }
        /* Style du bouton de changement d'état */
        .changer-etat {
            background-color: #ccc;
            padding: 5px;
            text-decoration: none;
            border-radius: 5px;
        }
        .changer-etat:hover {
            background-color: #aaa;
        }
    </style>
</head>
<body>


<h1>Historique des tickets</h1>

<ul>
        <li><a href="6_1_menu_technicien.php">home</a></li>
</ul>

<?php if (empty($tickets)): ?>
    <p>Aucun ticket trouvé.</p>
<?php else: ?>
    <?php foreach ($tickets as $ticket): ?>
        <div class="ticket <?= strtolower(str_replace(' ', '_', $ticket['etat_libelle'])) ?>">
            <h2>Ticket #<?= htmlspecialchars($ticket['id']) ?> - <?= htmlspecialchars($ticket['type_probleme']) ?></h2>
            <p><strong>Nom :</strong> <?= htmlspecialchars($ticket['nom']) ?></p>
            <p><strong>Email :</strong> <?= htmlspecialchars($ticket['email']) ?></p>
            <p><strong>type de probleme :</strong> <?= htmlspecialchars($ticket['type_de_probleme']) ?></p>
            <p><strong>Description :</strong> <?= nl2br(htmlspecialchars($ticket['probleme'])) ?></p>
            <p><strong>État :</strong> <?= htmlspecialchars($ticket['etat_libelle']) ?></p>
            <p><strong>Date de création :</strong> <?= htmlspecialchars($ticket['date_creation']) ?></p>

            <!-- Lien vers la page de consultation du ticket -->
            <p><a href="3_2_consulter_ticket.php?id=<?= $ticket['id'] ?>">Voir les détails</a></p>

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
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<ul>
        <li><a href="index.php">home</a></li>
</ul>

</body>
</html>
