<?php
ob_start(); // Démarrer la mise en tampon de sortie

// Inclure le fichier de connexion à la base de données
include '../database/bdd.php'; // Assurez-vous que le chemin est correct

// Fonction pour l'inscription d'un utilisateur
function register($username, $password)
{
    global $db;

    $query = "SELECT * FROM user WHERE username = :username";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        return "Ce pseudo est déjà utilisé.";
    }

    // Hachage du mot de passe
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insertion de l'utilisateur dans la base de données
    $query = "INSERT INTO user (username, password, admin) VALUES (:username, :password, 0)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashedPassword);
    if ($stmt->execute()) {
        return "Inscription réussie ! Vous pouvez maintenant vous connecter.";
        header("Location: ../loginPage/loginPage.php");
    } else {
        return "Erreur lors de l'inscription. Veuillez réessayer.";
    }
}

// Traitement du formulaire d'inscription
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['Pseudo'] ?? '';
    $password = $_POST['Password'] ?? '';
    $message = register($username, $password);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/loginPage.css">
    <title>GameHub | Inscription</title>
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
            <h1>Inscription</h1>
            <label for="Pseudo">Votre pseudo:</label>
            <input type="text" name="Pseudo" placeholder="Votre nom d'utilisateur" required>
            <label for="Password">Votre mot de passe:</label>
            <input type="password" name="Password" placeholder="Votre mot de passe" required>
            <input type="submit" value="S'inscrire">
        </form>
        <p style="color: red;"><?= htmlspecialchars($message) ?? '' ?></p>
    </div>
</body>

</html>