<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oups</title>

    <link rel="stylesheet" href="../stylesheet/styles.css">
    <link rel="stylesheet" href="../stylesheet/erreur.css">
</head>
<body>
    <h2>Il semble qu'une erreur se soit produite...</h2>
    <?php 
    session_start();
    // On récupère la requête
    $e = $_SESSION['erreur'];
    if(!empty($e)) {
        echo $e->getMessage();
        exit;
    } 
    ?>
</body>
</html>

