<?php
session_start();
include "../database/bdd.php";

if (!isset($_SESSION['username']) || !isset($_SESSION['user_id']) || !isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    header("Location: ../loginPage/loginPage.php");
    exit();
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

function fetchUsers()
{
    global $db;
    $query = "SELECT * FROM user";
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); //
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/adminBoard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>GameHub | AdminBoard</title>
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <img src="../images/logoGameHub.webp" alt="Logo de GameHub">
            </div>
            <div class="userInfo">
                <p><?php echo htmlspecialchars($_SESSION['username']); ?></p>
                <form method="post" style="display:inline;">
                    <button type="submit" name="logout" style="background:none; border:none; cursor:pointer;">
                        <i class="fa-solid fa-door-open"></i>
                    </button>
                </form>
            </div>
        </nav>
    </header>

    <div class="adminContent">
        <h1>Bienvenue dans le panneau d'administration</h1>
        <div class="cardContainer">
            <div class="userControl">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom d'utilisateur</th>
                            <th>Admin</th>
                            <th>Actions</th> <!-- Colonne Actions -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $users = fetchUsers();
                        foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['id']); ?></td>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                <td><?php echo htmlspecialchars($user['admin'] ? 'Oui' : 'Non'); ?></td>
                                <td>
                                    <!-- Bouton de modification -->
                                    <a href="../editPage/editUser.php?id=<?php echo $user['id']; ?>" class="editButton">Modifier</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>