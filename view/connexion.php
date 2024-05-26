<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diaconat - Connexion</title>

    <link rel="stylesheet" href="../stylesheet\styles.css">
    <link rel="stylesheet" href="../stylesheet\connexion.css">
    <link rel="stylesheet" href="../stylesheet\AnimateLignes.css">
</head>
<body>
    <img src="../assets\img\ico_diaconat_mulhouse.webp">

    <?php 
    require_once("../components/connect_server.php");
    require_once("../objects/Utilisateurs.php");

    // On récupère l'accès à la base de données
    global $bdd;

    // On réagit à la validation du formulaire
    if($_SERVER["REQUEST_METHOD"] == "POST") try {
        // On récupère les données saisies
        $identifiant = $_POST["identifiant"];
        $motdepasse = $_POST["motdepasse"];

        // On vérifie leur intégrité
        if(empty($identifiant)) {
            throw new Exception("Le champs identifiant doit être rempli !");
        } elseif(empty($motdepasse)) {
            throw new Exception("Le champs mot de passe doit être rempli !");
        } 

        // On récupère les rôles
        $sql = "SELECT * FROM utilisateurs WHERE Nom = :Identifiant";
        $query = $bdd->prepare($sql);
        $query->execute([
            "Identifiant" => $identifiant
        ]);
        $users = $query->fetchAll(PDO::FETCH_ASSOC);

        // On vérifie qu'il y a des utilisateurs
        if(empty($users)) 
        // On émet une erreur si la base de données est vide
            throw new Exception("Aucun utilisateur enregistré");

        // Sinon, on cherche le profil de l'utilisateur    
        else {
            // On déclare les variables tampons
            $i = 0;
            $size = count($users);
            $find = false;

            // On fait défiler la table
            while($i < $size && !$find) {
                if($users[$i]["Nom"] == $identifiant && password_verify($motdepasse, $users[$i]["MotDePasse"])) {
                    // On implémente find
                    $find = true;
                    // On récupère le rôle de l'utilisateur
                    $role = Utilisateurs::searchRole($bdd, $users[$i]["Id_Roles"]);
                    // On construit l'utilisateur php
                    $user = new Utilisateurs($users[$i]["Nom"], $users[$i]["Email"], $motdepasse, $role["Intitule"]);

                    // On enregistre la connexion de l'utilisateur
                    include ('../components/connect_user.php');

                    // On prépare la redirection de l'utilisateur
                    session_start();
                    $_SESSION['user'] = $user->exportToArray();
                    // On redirige la page
                    header("Location: ../index.php");
                    exit;
                }
                $i++;
            }
            if($i == $size) 
                throw new Exception("Aucun utilisateur correspondant");
            
        }
    } catch(PDOException $e){
        echo "<script>console.log(\"PDOException : " . $e->getMessage() . "\"); </script>";
    } catch(Exception $e){
        echo "<script>console.log(\"Exception : " . $e->getMessage() . "\"); </script>";
    }
    ?>

    <form method="post">
        <h1>Se connecter</h1>
        <div class="separator"></div>
        <section>
            <label for="identifiant">Identifiant :</label>
            <input type="text" id="identifiant" name="identifiant">
        </section>
        <section>
            <label for="motdepasse">Mot de passe :</label>
            <input type="password" id="motdepasse" name="motdepasse">
        </section>
        <section class="buttons_actions">
            <button type="submit" class="submit_button" value="new_user">Valider</button>
        </section>
    </form>
    <a class="LignesHover user-link" href="inscription.php">Nouvel utilisateur</a>
</body>
</html>