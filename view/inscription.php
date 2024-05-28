<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diaconat - Inscription</title>

    <link rel="stylesheet" href="../stylesheet\styles.css">
    <link rel="stylesheet" href="../stylesheet\connexion.css">
</head>
<body>
    <img src="../assets\img\photo_log-in.jpg" alt="Illustration de l'hopithal">
    
    <?php 

    require_once('../components/connect_server.php');
    require_once("../objects/Utilisateurs.php");

    // On réagit à la validation du formulaire
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
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

        } catch(Exception $e){
            session_start();
            $_SESSION['erreur'] = $e;
            // On redirige la page
            header("Location: erreur.php");
            exit;
        }

        // On récupère le rôle invité
        $sql = "SELECT * FROM roles WHERE Intitule = :Intitule";
        $result = get_request($bdd, $sql, ["Intitule" => "Invite"], true, true);
        // On implémente
        $role = $result['Intitule'];
        $role_id = $result['Id'];

        // On génère un nouvel Utilisateur selon les données
        $new_user = new Utilisateurs($identifiant, $email, $motdepasse, $role);
        $sql = "INSERT INTO utilisateurs (nom, email, motdepasse, id_Roles)  VALUES (:nom, :email, :motdepasse, :id_Roles)";
        post_request($bdd, $sql, $new_user->exportToSQL($bdd));

        try {
            // On récupère les utilisateurs
            $sql = "SELECT * FROM Utilisateurs WHERE Nom = :nom";
            $query = $bdd->prepare($sql);
            $query->execute([":nom" => $identifiant]);
            $users = $query->fetchAll(PDO::FETCH_ASSOC);
            
            // On vérifie qu'il y a des utilisateurs
            if(empty($users)) 
                // On émet une erreur si la base de données est vide
                throw new Exception("Aucun utilisateur enregistré");
   
        } catch(PDOException $e){
            echo "<script>
                console.log(\"Erreur PDO : " . $e->getMessage() . " \");
                console.log(\"Code d'erreur PDO : " . $e->getCode() . " \");
            </script>";
        } catch(Exception $e){
            echo "<script>console.log(\"Aucun utilisateur enregistré correspondant à la requête\");</script>";
        }

        // On déclare les variables tampons
        $i = 0;
        $size = count($users);
        $find = false;  

        // On fait défiler la table
        while($i < $size && !$find) {
            if($users[$i]["Nom"] == $new_user->getIdentifiant() && $users[$i]["Email"] == $new_user->getEmail()) {              
                // On implémente find
                $find = true;
                // On récupère le rôle de l'utilisateur
                $role = Utilisateurs::searchRole($bdd, $users[$i]["Id_Roles"]);
                // On construit l'utilisateur php
                $user = new Utilisateurs($users[$i]["Nom"], $users[$i]["Email"], $motdepasse, $role["Intitule"]);
                $user->searchCle($bdd);

                // On prépare la redirection de l'utilisateur
                session_start();
                $_SESSION['user'] = $user->exportToArray();
                $_SESSION['intitule'] = "Première connexion de " . $user->getIdentifiant();

                // On enregistre la connexion de l'utilisateur
                require_once ('../components/connect_user.php');

                // On redirige la page
                header("Location: ../index.php");
                exit;
            }
            $i++;
        }
        if($i == $size) 
            throw new Exception("Erreur lors du chargement du profil");
    }
    ?>

    <form method="post">
        <img src="../assets\img\ico_diaconat_mulhouse.webp">
        <h2>Saisissez vos infrmations pour vous inscrire</h2>
        <input type="text" id="identifiant" name="identifiant" placeholder="Identifiant">
        <input type="text" id="email" name="email" placeholder="Adresse mail">
        <input type="password" id="motdepasse" name="motdepasse" placeholder="Mot de passe">
        <input type="password" id="confirmation" name="confirmation" placeholder="Confirmation du mot de passe">
        <section class="checkbox-liste">
            <div class="checkbox-item">
                <label for="remember1">Se souvenir de moi</label>
                <input type="checkbox" id="remember1" name="option1" value="option1">
            </div>
        </section>
        <section class="buttons_actions">
            <button type="submit" class="submit_button" value="new_user">Valider</button>
        </section>
        <p class="user-link">Vous avez déjà un compte <a href="connexion.php">Connectez-vous</a><p>
    </form>
</body>
</html>