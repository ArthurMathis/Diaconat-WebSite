<?php 

require_once('define.php');
require_once(CONTROLLERS.DS.'LoginController.php');
require_once(CONTROLLERS.DS.'HomeController.php');
require_once(CONTROLLERS.DS.'CandidaturesController.php');

// On démarre la session de l'utilisateur
session_start();

// On lance la connexion à la base de données
env_start();

if(isset($_GET['login'])) {
    $login = new LoginController();
    switch($_GET['login']) {
        // On connecte l'utilisateur     
        case 'connexion' : 
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
    
            // On récupère et retourne les éventuelles erreurs    
            } catch(Exception $e){
                $login->displayErreur($e);
                exit;
            }

            try {
                // On identifie l'utilisateur
                $login->checkIdentification($identifiant, $motdepasse);

            // On récupère les éventuelles erreurs    
            } catch(Exception $e) {
                $login->displayErreur($e);
                return ;
            }

            // On sort de la boucle swicth
            break;

        // On inscrit l'utilisateur    
        case 'inscription' : 
            try {
                // On récupère les données saisies
                $identifiant    = $_POST["identifiant"];
                $email          = $_POST["email"];
                $motdepasse     = $_POST["motdepasse"];
                $confirmation   = $_POST["confirmation"];
    
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

            // On récupère les éventuelles erreurs    
            } catch(Exception $e){
                $login->displayErreur($e);
                exit;
            }

            try {
                // On inscrit l'utilisateur
                $login->createIdentification($identifiant, $email, $motdepasse);

            // On récupère les éventuelles erreurs        
            } catch(Exception $e) {
                $login->displayErreur($e);
                exit;
            }

            // On sort de la boucle swicth
            break;    

        // On déconnecte l'utilisateur    
        case 'deconnexion' : 
            $login->closeSession();
            break;

        // On retourne le formulaire de connexion
        case 'get_connexion' :
            $login->displayLogin(); 
            break;

        // On retourne le formulaire d'inscription
        case 'get_inscription' : 
            $login->displaySignin();
            break;    

        default : 
            $c->displayLogin();
            break;
    }

} elseif(isset($_GET['candidatures'])) {
    $candidatures = new CandidaturesController();
    switch($_GET['candidatures']) {
        case 'home' :
            $candidatures->dispayCandidatures();
            break;

        case 'saisie-candidat' : 
            $candidatures->displaySaisieCandidat();
            break;
            
        case 'saisie-candidature' : 
            $candidatures->displaySaisieCandidature();
            break;

        case 'inscription-candidat' :
            // On récupère le contenu des champs
            $nom            = $_POST["nom"];
            $prenom         = $_POST["prenom"];
            $email          = $_POST["email"];
            $telephone      = $_POST["telephone"];
            $adresse        = $_POST["adresse"];
            $ville          = $_POST["ville"];
            $code_postal = $_POST['code-postal'];
            // $aides      = $_POST["identifiant"];
            $diplomes = [
                $_POST["diplome-1"], 
                $_POST["diplome-2"], 
                $_POST["diplome-3"]
            ];
            
            try {
                if(empty($nom)) {
                    throw new Exception("Le champs nom doit être remplis par une chaine de caractères");
                } elseif(empty($prenom)) {
                    throw new Exception("Le champs prenom doit être remplis par une chaine de caractères");
                } elseif(empty($email)) {
                    throw new Exception("Le champs email doit être remplis par une chaine de caractères");
                } elseif(empty($adresse)) {
                    throw new Exception("Le champs adresse doit être remplis par une chaine de caractères");
                } elseif(empty($ville)) {
                    throw new Exception("Le champs ville doit être remplis par une chaine de caractères");
                } elseif(empty($code_postal)) {
                    throw new Exception("Le champs code postal doit être remplis par une chaine de caractères");
                } 

            } catch(Exception $e) {
                $candidatures->displayErreur($e);
                exit;
            }

            // On sauvegarde les données dans la session
            $_SESSION['candidat'] = [
                'nom' => $nom, 
                'prenom' =>$prenon, 
                'email' => $email, 
                'telephone' => $telphone, 
                'adresse' => $adresse,
                'ville' => $ville,
                'code postale' => $code_postale, 
                'diplomes' => $diplomes
            ];

            // On redirige vers le prochain formulaire
            header('Location: index.php?candidatures=saisie-candidature');
            break;

            case 'inscription-candidature' :
                // On récupère le contenu des champs
                $poste          = $_POST["poste"];
                $service        = $_POST["service"];
                $disponibilite  = $_POST["disponibilite"];
                $source         = $_POST["source"];
                
                try {
                    if(empty($poste)) {
                        throw new Exception("Le champs poste doit être remplis par une chaine de caractères");
                    } elseif(empty($prdisponibiliteenom)) {
                        throw new Exception("Le champs date doit être remplis par une chaine de caractères");
                    } elseif(empty($source)) {
                        throw new Exception("Le champs source doit être remplis par une chaine de caractères");
                    }
    
                } catch(Exception $e) {
                    $candidatures->displayErreur($e);
                    exit;
                }

                $infos_candidatures = [
                    'poste' => $poste, 
                    'service' =>$service, 
                    'disponibilite' => $disponibilite, 
                    'source' => $source
                ];
                // On récupère le candidat
                $infos_candidats = $_SESSION['candidat'];
                unset($_SESSION['candidat']);

                $candidatures->createcandidat($infos_candidats, $infos_candidatures);

                break;
    

        default : 
            $candidatures->dispayCandidatures();
            break;
    }

} elseif(isset($_SESSION['user_cle'])) {
    $home = new HomeController();
    $home->displayHome();

} else {
    $c = new LoginController();
    $c->displayLogin();
}