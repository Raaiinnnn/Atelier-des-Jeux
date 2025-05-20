<ul>
        <li><a href="6_1_menu_technicien.php">home</a></li>
</ul>
<form method="GET" action="logs.php">
    <label for="user_id">ID Utilisateur:</label>
    <input type="text" id="user_id" name="user_id" value="<?php echo isset($_GET['user_id']) ? htmlspecialchars($_GET['user_id']) : ''; ?>">
    
    <label for="start_datetime">Date et Heure de début:</label>
    <input type="datetime-local" id="start_datetime" name="start_datetime" value="<?php echo isset($_GET['start_datetime']) ? htmlspecialchars($_GET['start_datetime']) : ''; ?>">
    
    <label for="end_datetime">Date et Heure de fin:</label>
    <input type="datetime-local" id="end_datetime" name="end_datetime" value="<?php echo isset($_GET['end_datetime']) ? htmlspecialchars($_GET['end_datetime']) : ''; ?>">
    
    <input type="submit" value="Filtrer">
</form>

<?php
// Afficher les erreurs PHP pour déboguer
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    die("Accès refusé. Vous devez être connecté.");
}

include "db.php";

// Construire la requête de base
$query = "
    SELECT logs.id, logs.user_id, logs.action, logs.date_action, users.username 
    FROM logs
    JOIN users ON logs.user_id = users.id
    WHERE 1=1
";

// Préparer un tableau pour stocker les paramètres de la requête
$params = [];

// Ajouter les filtres s'ils sont présents dans la requête GET
if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
    $query .= " AND user_id = :user_id";
    $params['user_id'] = $_GET['user_id'];
}

if (isset($_GET['start_datetime']) && !empty($_GET['start_datetime'])) {
    $query .= " AND date_action >= :start_datetime";
    $params['start_datetime'] = $_GET['start_datetime'];
}

if (isset($_GET['end_datetime']) && !empty($_GET['end_datetime'])) {
    $query .= " AND date_action <= :end_datetime";
    $params['end_datetime'] = $_GET['end_datetime'];
}

// Ajouter l'ordre de tri
$query .= " ORDER BY date_action DESC"; // Tri par date et heure

// Préparer et exécuter la requête avec les paramètres
$stmt = $bdd->prepare($query);
$stmt->execute($params);

// Récupérer les logs filtrés
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Afficher les logs
if ($logs) {
    echo "<h1>Historique des actions</h1>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Utilisateur</th><th>Action</th><th>Date</th></tr>";
    foreach ($logs as $log) {
        echo "<tr>";
        echo "<td>" . $log['id'] . "</td>";
        echo "<td>" . $log['user_id'] . " - " . htmlspecialchars($log['username']) . "</td>"; // Correction ici
        echo "<td>" . htmlspecialchars($log['action']) . "</td>";
        echo "<td>" . $log['date_action'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Aucun log trouvé.";
}
?>
