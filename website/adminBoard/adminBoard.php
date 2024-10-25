<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['user_id']) || !isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    header("Location: ../loginPage/loginPage.php");
    exit();
}

function logOut()
{
    session_destroy();
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
                <i class="fa-solid fa-door-open" onclick=logOut();></i>
            </div>
        </nav>
    </header>

    <div class="adminContent">
        <h1>Bienvenue dans le panneau d'administration</h1>
        <div class="cardContainer">

        </div>
    </div>
</body>

</html>