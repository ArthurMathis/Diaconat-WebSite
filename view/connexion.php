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
            $sql = "SELECT * FROM utilisateurs WHERE Nom = :Identifiant AND MotDePasse = :Motdepasse";
            $query = $bdd->prepare($sql);
            $query->execute([
                "Identifiant" => $identifiant,
                "Motdepasse" => $motdepasse
            ]);
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            if(empty($result)) 
                throw new Exception("Aucun utilisateur correspondant");

            else {
                foreach($result as $item) {
                    if($item["Nom"] == $identifiant && $item["MotDePasse"] == $motdepasse) {
                        // On récupère le rôle correspondant à l'Id_Role
                        $role = Utilisateurs::searchRole($bdd, $item["Id_Roles"]);
                        $user = new Utilisateurs($identifiant, $item["Email"], $motdepasse, $role);

                        // On prépare la redirection del'utilisateur
                        session_start();
                        $_SESSION['user'] = [$user];
                        // On redirige la page
                        header("Location: ../index.php");
                        exit;

                        // On arrête la boucle
                        break;
                    }
                        
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
            <a class="LignesHover" href="view/inscription.php">Nouvel utilisateur</a>
        <button type="submit" class="submit_button" value="new_user">Valider</button>
        </section>
    </form>
</body>
</html>