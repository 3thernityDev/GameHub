<?php
ob_start();
include '../database/bdd.php';

// Vérifiez si l'utilisateur est connecté
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    header("Location: ../loginPage/loginPage.php");
    exit();
}

// Fonction pour modifier un utilisateur
function editUser($userId, $username, $password)
{
    global $db;

    $query = "SELECT * FROM user WHERE username = :username AND id != :userId";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        return "Ce pseudo est déjà utilisé.";
    }

    // Préparer la requête de mise à jour
    if (!empty($password)) {
        // Hachage du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Mise à jour du pseudo et du mot de passe
        $query = "UPDATE user SET username = :username, password = :password WHERE id = :userId";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':password', $hashedPassword);
    } else {
        // Mise à jour uniquement du pseudo
        $query = "UPDATE user SET username = :username WHERE id = :userId";
        $stmt = $db->prepare($query);
    }

    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':userId', $userId);

    // Exécuter la mise à jour
    if ($stmt->execute()) {
        return "Informations mises à jour avec succès !";
    } else {
        return "Erreur lors de la mise à jour des informations. Veuillez réessayer.";
    }
}


// Traitement du formulaire de modification
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id']; // On laisse l'utilisateur modifier uniquelent sont profil grace au user id 
    $username = $_POST['Pseudo'] ?? '';
    $password = $_POST['Password'] ?? '';
    $message = editUser($userId, $username, $password);
}

// On recup les infos de l'utilisateur
$userId = $_SESSION['user_id'];
$query = "SELECT * FROM user WHERE id = :userId";
$stmt = $db->prepare($query);
$stmt->bindParam(':userId', $userId);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/loginPage.css">
    <title>GameHub | Modifier Utilisateur</title>
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <img src="../images/logoGameHub.webp" alt="Logo de GameHub">
            </div>
            <div class="logOPT">
                <a href="../index.php"><button class="cancel">Annuler</button></a>
            </div>
        </nav>
    </header>

    <div class="formContainer">
        <form action="" method="post">
            <h1>Modifier Utilisateur</h1>
            <label for="Pseudo">Votre pseudo:</label>
            <input type="text" name="Pseudo" value="<?= htmlspecialchars($user['username']) ?>" required>
            <label for="Password">Votre mot de passe:</label>
            <input type="password" name="Password" placeholder="Laissez vide pour ne pas changer">
            <input type="submit" value="Modifier">
        </form>
        <p style="color: red;"><?= htmlspecialchars($message) ?? '' ?></p>
    </div>
</body>

</html>