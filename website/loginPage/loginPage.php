<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/loginPage.css">
    <title>GameHub | Ce connecter</title>
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
        <form action="">
            <h1>Connexion</h1>
            <label for="Pseudo">Votre pseudo:</label>
            <input type="text" name="Pseudo" placeholder="Votre nom d'utilisateur" require>
            <label for="password">Votre mot de passe:</label>
            <input type="password" name="Password" placeholder="Votre mot de passe" require>
            <input type="submit" value="Connexion">
        </form>
    </div>
</body>

</html>