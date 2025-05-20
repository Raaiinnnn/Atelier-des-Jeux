<?php
try {
    include 'db.php';

    $bdd = new PDO("mysql:host=$server;dbname=$dbname;charset=utf8", $user, $passwd);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Préparation
    $stmt = $bdd->prepare('INSERT INTO tickets(nom, email, type_de_probleme, probleme) 
                           VALUES(:nom, :email, :type_de_probleme, :probleme)');

    // Récupération des champs avec fallback
    $nom = $_POST['nom'] ?? '';
    $email = $_POST["email"] ?? '';
    $type_probleme = $_POST["type_de_probleme"] ?? '';
    $probleme = $_POST["probleme"] ?? '';

    // Bind des valeurs
    $stmt->bindValue(':nom', $nom, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':type_de_probleme', $type_probleme, PDO::PARAM_STR);
    $stmt->bindValue(':probleme', $probleme, PDO::PARAM_STR);

    // Exécution
    $stmt->execute();

    echo 'Le ticket a bien été ajouté !';
// Redirection vers la page de gestion des tickets
header("Location: 2_3_ticket_reussi.html");
} catch (PDOException $e) {
    echo 'Erreur : ' . $e->getMessage();
}

?>