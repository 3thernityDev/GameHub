<?php
session_start();
include '../database/bdd.php';

// Vérifiez si l'administrateur est connecté
if (!isset($_SESSION['username']) || !isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    header("Location: ../loginPage/loginPage.php");
    exit();
}

// Fonction pour récupérer et mettre à jour les informations de l'utilisateur
function getUser($userId)
{
    global $db;
    $query = "SELECT * FROM user WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $userId);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateUser($userId, $username, $isAdmin)
{
    global $db;
    $query = "UPDATE user SET username = :username, admin = :admin WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':admin', $isAdmin, PDO::PARAM_INT);
    $stmt->bindParam(':id', $userId);
    return $stmt->execute();
}

// Récupération des informations de l'utilisateur à modifier
$userId = $_GET['id'];
$user = getUser($userId);

// Traitement de la mise à jour du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $isAdmin = isset($_POST['admin']) ? 1 : 0;
    if (updateUser($userId, $username, $isAdmin)) {
        header("Location: ../adminBoard/adminBoard.php");
        exit();
    } else {
        $message = "Erreur lors de la mise à jour des informations. Veuillez réessayer.";
    }
}

function logOut()
{
    session_destroy();
    header("Location: ../loginPage/loginPage.php"); // Redirect after logout
    exit();
}

// Check if the logout request is made
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    logOut();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/editUser.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>GameHub | Modifier Utilisateur</title>
</head>
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

<body>
    <div class="formContainer">
        <form action="" method="post">
            <h1>Modifier Utilisateur</h1>
            <label for="username">Pseudo de l'utilisateur :</label>
            <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>

            <label for="admin">L'utilisateur est-il administrateur ?</label>
            <input type="checkbox" name="admin" <?= $user['admin'] ? 'checked' : ''; ?>>

            <button type="submit">Modifier</button>
            <a href="../adminBoard/adminBoard.php">Annuler</a>
        </form>
        <p style="color: red;"><?= htmlspecialchars($message ?? '') ?></p>
    </div>
</body>

</html>