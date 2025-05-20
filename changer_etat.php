<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ticket_id = intval($_POST['ticket_id']);
    $action    = $_POST['action'];

    // Mise à jour de l'état du ticket
    $sql = "UPDATE tickets SET etat = '$action' WHERE id = $ticket_id";

    if ($conn->query($sql) === true) {
        echo "État du ticket mis à jour ! <a href='admin_tickets.php'>Retour à la liste des tickets</a>";
    } else {
        echo "Erreur : " . $conn->error;
    }
}
