<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diaconat - Connexion</title>

    <link rel="stylesheet" href="../stylesheet\styles.css">
    <link rel="stylesheet" href="../stylesheet\connexion.css">
    <link rel="stylesheet" href="../stylesheet/AnimateLignes.css">
</head>
<body>
    <img src="../assets\img\photo_log-in.jpg" alt="Illustration de l'hopithal">

    <?php
    
    require_once("../components/connect_server.php");
    require_once("../objects/Utilisateurs.php");

    // On récupère l'accès à la base de données
    global $bdd;

    if(empty($bdd)) 
        header("Location: erreur.php"); 

    elseif($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            // On récupère les données saisies
            $identifiant = $_POST["identifiant"];
            $motdepasse = $_POST["motdepasse"];
            
            // On vérifie leur intégrité
            if(empty($identifiant)) {
                throw new Exception("Le champs identifiant doit être rempli !");
            } elseif(empty($motdepasse)) {
                throw new Exception("Le champs mot de passe doit être rempli !");
            } 

        } catch(Exception $e){
            session_start();
            $_SESSION['erreur'] = $e;
            // On redirige la page
            header("Location: erreur.php");
            exit;
        }

        global $identifiant;
        global $motdepasse;

        try {
            // On récupère les rôles
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

        global $users;

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
                $user->searchCle($bdd);

                // On prépare la redirection de l'utilisateur
                session_start();
                $_SESSION['user'] = $user->exportToArray();
                $_SESSION['intitule'] = "Connexion de " . $user->getIdentifiant();

                // On enregistre la connexion de l'utilisateur
                require_once ('../components/connect_user.php');

                // On redirige la page
                header("Location: ../index.php");
                exit;
            }
            $i++;
        }
        if($i == $size) 
            throw new Exception("Aucun utilisateur correspondant");
        
    }
    ?>
    
    <form method="post">
    <img src="../assets/img/ico_diaconat_mulhouse.webp">
    <h2>Entrez votre identifiant et mot de passe pour accéder au site web</h2>
    <input type="text" id="identifiant" name="identifiant" placeholder="Identifiant">
    <input type="password" id="motdepasse" name="motdepasse" placeholder="Mot de passe">
    <section class="checkbox-liste">
        <div class="checkbox-item">
            <label for="remember1">Se souvenir de moi</label>
            <input type="checkbox" id="remember1" name="option1" value="option1">
        </div>
        <a class="LignesHover" href="">Mot de passe oublié</a>
    </section>
    <section class="buttons_actions">
        <button type="submit" class="submit_button" value="new_user">Se connecter</button>
    </section>
    <p class="user-link">Vous n'avez pas de compte <a href="inscription.php">Inscrivez-vous</a><p>
</form>
</body>
</html>