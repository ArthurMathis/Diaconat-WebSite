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
        require_once('../components/connect_server.php');
        require_once("../objects/Utilisateurs.php");

        // On récupère l'accès à la base de données
        global $bdd;

        // On réagit à la validation du formulaire
        if($_SERVER["REQUEST_METHOD"] == "POST") try {
            // On récupère les données saisies
            $identifiant = $_POST["identifiant"];
            $email = $_POST["email"];
            $motdepasse = $_POST["motdepasse"];
            $confirmation = $_POST["confirmation"];

            // On vérifie leur intégrité
            if(empty($identifiant)) {
                throw new Exception("Le champs identifiant doit être rempli !");
            } elseif(empty($email)) {
                throw new Exception("Le champs email doit être rempli !");
            }  elseif(empty($motdepasse)) {
                throw new Exception("Le champs mot de passe doit être rempli !");
            }  elseif(empty($confirmation)) {
                throw new Exception("Le champs confirmation doit être rempli !");
            } elseif($motdepasse != $confirmation) {
                throw new Exception("Les champs mot de passe et confirmation doivent être identiques");
            }

            // On récupère les rôles
            $sql = "SELECT * FROM roles WHERE Intitule = :Intitule";
            $query = $bdd->prepare($sql);
            $query->execute(["Intitule" => "Administrateur"]);
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            if(empty($result)) 
                throw new Exception("Erreur de récupération du rôle l'utilisateur");

            else {
                $role = $result[0]['Intitule'];
                $role_id = $result[0]['Id'];
            }

            // On génère un nouvel Utilisateur selon les données
            $new_user = new Utilisateurs($identifiant, $email, $motdepasse, $role);
        
            // On génère une requête MySQL
            $query =  $bdd->prepare("INSERT INTO utilisateurs (nom, email, motdepasse, id_Roles)  VALUES (:nom, :email, :motdepasse, :id_Roles)");
            // On envoie la requête au serveur
            $query->execute([
                "nom" => $new_user->getIdentifiant(),
                "email" => $new_user->getEmail(),
                "motdepasse" =>  $new_user->getMotdepasse(), 
                "id_Roles" => $role_id
            ]);
        } catch(Exception $e) {
            echo "<script>
                    console.log(\" . " . $e->getMessage() . " . \")
                </script>";
        }  catch(InvalideUtilisateurExceptions $e) {
            echo "<script>
                    console.log(\" . " . $e->getMessage() . " . \")
                </script>";
        } catch(PDOException $e){
            echo "<script>
                    console.log(\" . " . $e->getMessage() . " . \")
                </script>";
        }

        // On prépare la redirection del'utilisateur
        session_start();
        $_SESSION['user'] = [$new_user];
        // On redirige la page
        header("Location: accueil.php");
        exit;
    ?>

    <form method="post">
        <h1>S'inscrire</h1>
        <div class="separator"></div>
        <section>
            <label for="identifiant">Identifiant :</label>
            <input type="text" id="identifiant" name="identifiant">
        </section>
        <section>
            <label for="email">Email :</label>
            <input type="text" id="email" name="email">
        </section>
        <section>
            <label for="motdepasse">Mot de passe :</label>
            <input type="password" id="motdepasse" name="motdepasse">
        </section>
        <section>
            <label for="confirmation">Confirmer le mot de passe :</label>
            <input type="password" id="confirmation" name="confirmation">
        </section>
        <section class="buttons_actions">
            <a class="LignesHover" href="../index.php">Se connecter</a>
        <button type="submit" class="submit_button" value="new_user">Valider</button>
        </section>
    </form>
</body>
</html>