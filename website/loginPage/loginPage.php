<?php
ob_start(); // Démarrer la mise en tampon de sortie

// Inclure le fichier de connexion à la base de données
include '../database/bdd.php'; // Assurez-vous que le chemin est correct

// Fonction pour le login
function login($username, $password)
{
    global $db;
    $query = "SELECT * FROM user WHERE username = :username";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if ($password == $user['password']) {
            session_start();
            if (isset($user['id'])) {
                $_SESSION['user_id'] = $user['id'];
            }
            $_SESSION['username'] = $user['username'];
            header("Location: ../adminBoard/adminBoard.php");
            exit();
        } else {
            return "Mot de passe incorrect.";
        }
    } else {
        return "Aucun utilisateur trouvé avec ce pseudo.";
    }
}

// Traitement du formulaire de connexion
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['Pseudo'];
    $password = $_POST['Password'];
    $message = login($username, $password);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/loginPage.css">
    <title>GameHub | Se connecter</title>
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
            <h1>Connexion</h1>
            <label for="Pseudo">Votre pseudo:</label>
            <input type="text" name="Pseudo" placeholder="Votre nom d'utilisateur" required>
            <label for="Password">Votre mot de passe:</label>
            <input type="password" name="Password" placeholder="Votre mot de passe" required>
            <input type="submit" value="Connexion">
        </form>
        <p><?= $message ?? '' ?></p>
    </div>
</body>

</html>