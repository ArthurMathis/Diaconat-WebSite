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
    <?php require_once("../components/connect_server.php") ?>

    <img src="../assets\img\ico_diaconat_mulhouse.webp">

    <?php 
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
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            // On vérifie qu'il y a des utilisateurs
            if(empty($result)) 
            // On émet une erreur si la base de données est vide
                throw new Exception("Aucun utilisateur enregistré");

            // Sinon, on cherche le profil de l'utilisateur    
            else {
                // On déclare les variables tampons
                $i = 0;
                $size = count($result);
                $find = false;
                // On fait défiler la table
                while($i < $size && !$find) {
                    // if($result[$i]["Nom"] == $identifiant && $result[$i]["MotDePasse"] == $motdepasse) {
                    if($result[$i]["Nom"] == $identifiant && password_verify($motdepasse, $result[$i]["MotDePasse"])) {
                        // On implémente find
                        $find = true;

                        // On récupère le rôle de l'utilisateur
                        $role = Utilisateurs::searchRole($bdd, $result[$i]["Id_Roles"]);
                    
                        // On construit l'utilisateur php
                        $user = new Utilisateurs($result[$i]["Nom"], $result[$i]["Email"], $motdepasse, $role["Intitule"]);

                        // On prépare la redirection del'utilisateur
                        session_start();
                        $_SESSION['user'] = $user->exportToArray();
                        // On redirige la page
                        header("Location: ../index.php");
                        exit;
                    }
                    echo "<script>console.log(\"".$result[$i]["Nom"]."\");</script>";
                    echo "<script>console.log(\"".$result[$i]["MotDePasse"]."\");</script>";
                    echo "<script>console.log(\"".password_hash($motdepasse, PASSWORD_DEFAULT)."\");</script>";

                    $i++;
                }
                if($i == $size) {
                    throw new Exception("Aucun utilisateur correspondant");
                }
            }
        } catch(PDOException $e){
            echo "<script>
                    console.log(\"" . $e->getMessage() . "\")
                </script>";
        } catch(Exception $e){
            echo "<script>
                    console.log(\"" . $e->getMessage() . "\")
                </script>";
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
            <a class="LignesHover" href="inscription.php">Nouvel utilisateur</a>
        <button type="submit" class="submit_button" value="new_user">Valider</button>
        </section>
    </form>
</body>
</html>