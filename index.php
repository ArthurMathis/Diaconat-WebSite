<?php 

require_once('define.php');
require_once(CONTROLLERS.DS.'LoginController.php');
require_once(CONTROLLERS.DS.'HomeController.php');
require_once(CONTROLLERS.DS.'CandidaturesController.php');
require_once(CONTROLLERS.DS.'CandidatsController.php');
require_once(COMPONENTS.DS.'forms_manip.php');

// On démarre la session de l'utilisateur
session_start();

// On récupère les infos de connexion à la base de données
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
                forms_manip::error_alert($e->getMessage());
            }

            try {
                // On identifie l'utilisateur
                $login->checkIdentification($identifiant, $motdepasse);

            // On récupère les éventuelles erreurs    
            } catch(Exception $e) {
                forms_manip::error_alert($e->getMessage());
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
                forms_manip::error_alert($e->getMessage());
            }

            try {
                // On inscrit l'utilisateur
                $login->createIdentification($identifiant, $email, $motdepasse);

            // On récupère les éventuelles erreurs        
            } catch(Exception $e) {
                forms_manip::error_alert($e->getMessage());
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

        case 'saisie-nouveau-candidat' : 
            $candidatures->displaySaisieCandidat();
            break;

        case 'saisie-candidat' :   
            $candidatures->displayRechercheCandidat();
            break; 
            
        case 'saisie-candidature' : 
            $candidatures->displaySaisieCandidature();
            break;

        // case 'saisie-proposition':
        //     $candidatures->displaySaisieProposition();    
        //     break;

        case 'inscription-candidat' :
            // On récupère le contenu des champs
            $nom            = forms_manip::nameFormat($_POST["nom"]);
            $prenom         = forms_manip::nameFormat($_POST["prenom"]);
            $email          = $_POST["email"];
            $telephone      = forms_manip::numberFormat($_POST["telephone"]);
            $adresse        = $_POST["adresse"];
            $ville          = forms_manip::nameFormat($_POST["ville"]);
            $code_postal    = $_POST['code-postal'];
            $diplomes = [
                $_POST["diplome-1"], 
                $_POST["diplome-2"], 
                $_POST["diplome-3"]
            ];
            $aide               = $_POST["aide"];
            $visite_medicale    = $_POST["visite_medicale"];
            
            try {
                if(empty($nom)) {
                    throw new Exception("Le champs nom doit être rempli par une chaine de caractères !");
                } elseif(empty($prenom)) {
                    throw new Exception("Le champs prenom doit être rempli par une chaine de caractères !");
                } elseif(empty($email)) {
                    throw new Exception("Le champs email doit être rempli par une chaine de caractères !");
                } elseif(empty($adresse)) {
                    throw new Exception("Le champs adresse doit être rempli par une chaine de caractères !");
                } elseif(empty($ville)) {
                    throw new Exception("Le champs ville doit être rempli par une chaine de caractères !");
                } elseif(empty($code_postal)) {
                    throw new Exception("Le champs code postal doit être rempli par une chaine de caractères !");
                } 
            
            } catch(Exception $e) {
                forms_manip::error_alert($e->getMessage());
            }

            foreach($diplomes as $d) {
                if(strlen($d) > 128) {
                    forms_manip::error_alert("Le diplome" . $d ." est trop volumineux. Veuillez réécrire son intitulé en max 128 caractères.");
                }
            }

            $candidat = [
                'nom' => $nom, 
                'prenom' => $prenom, 
                'email' => $email, 
                'telephone' => $telephone, 
                'adresse' => $adresse,
                'ville' => $ville, 
                'code_postal' => $code_postal
            ];

            $candidatures->checkCandidat($candidat, $diplomes, $aide, $visite_medicale == 'true' ? true : false);
            break;

        case 'recherche-candidat' : 
            // On récupère le contenu des champs
            $nom            = forms_manip::nameFormat($_POST["nom"]);
            $prenom         = forms_manip::nameFormat($_POST["prenom"]);
            $email          = $_POST["email"];
            $telephone      = forms_manip::numberFormat($_POST["telephone"]);

            try {
                if(empty($nom))
                    throw new Exception("Le champs nom doit être rempli !");
                elseif(empty($prenom))
                    throw new Exception("Le champs prenom doit être rempli !");
                elseif(empty($email))
                    throw new Exception("Le champs email doit être rempli !");
                elseif(empty($telephone))
                    throw new Exception("Le champs telephone doit être rempli !");
                    
            } catch(Exception $e) {
                forms_manip::error_alert($e->getMessage());
            }

            $candidatures->findCandidat($nom, $prenom, $email, $telephone);

            break;

        case 'inscription-candidature' :
            // On récupère le contenu des champs
            $poste          = forms_manip::nameFormat($_POST["poste"]);
            $service        = $_POST["service"];
            $type_contrat   = $_POST["type_de_contrat"];
            $disponibilite  = $_POST["disponibilite"];
            $source         = forms_manip::nameFormat($_POST["source"]);

            try {
                if(empty($poste)) {
                    throw new Exception("Le champs poste doit être rempli par une chaine de caractères");
                } elseif(empty($disponibilite)) {
                    throw new Exception("Le champs disponibilité doit être rempli par une chaine de caractères");
                } elseif(empty($source)) {
                    throw new Exception("Le champs source doit être rempli par une chaine de caractères");
                }

            } catch(Exception $e) {
                forms_manip::error_alert($e->getMessage());
            }
            
            $candidature = [
                'poste' => $poste, 
                'service' => $service, 
                'type de contrat' => $type_contrat,
                'disponibilite' => $disponibilite, 
                'source' => $source
            ];

            // On récupère le candidat
            $candidat = $_SESSION['candidat'];
            $diplomes = isset($_SESSION['diplomes']) && !empty($_SESSION['diplomes']) ? $_SESSION['diplomes'] : null;
            $aide = isset($_SESSION['aide']) && !empty($_SESSION['aide']) ? $_SESSION['aide'] : null;

            $candidatures->createCandidature($candidat, $candidature, $diplomes, $aide);
            break;
    
        default : 
            $candidatures->dispayCandidatures();
            break;
    }

} elseif(isset($_GET['candidats'])) {
    $candidats = new CandidatController();

    if(is_numeric($_GET['candidats'])) 
        $candidats->displayCandidat($_GET['candidats']);

    else try { 
        switch($_GET['candidats']) {
            case 'saisie-candidatures': 
                $candidats->getSaisieCandidature();
                break;
            
            case 'saisie-contrats' :
                break;
            
            case 'saisie-propositions' :
                try {
                    if(isset($_GET['cle_candidat']) && is_numeric($_GET['cle_candidat']))
                        $candidats->getSaisieProposition($_GET['cle_candidat']);
                    else 
                        throw new Exception("La clé candidat n'a pas pu être réceptionnée");

                } catch(Exception $e) {
                    forms_manip::error_alert($e);
                }
                break;

            case 'saisie-propositions-from-candidature':
                if(isset($_GET['cle']) && is_numeric($_GET['cle']))
                    $candidats->getSaisiePropositionFromCandidature($_GET['cle']);
                else 
                    forms_manip::error_alert("La clé n'a pas pu être détectée");
                break;
            
            case 'saisie-contrats' :
                break;
            
            case 'inscript-propositions':
                // On récupère les données du formulaire
                $infos = [
                    'poste' => $_POST['poste'],
                    'service' => $_POST['service'],
                    'type_de_contrat' => $_POST['type_contrat'],
                    'date debut' => $_POST['date_debut'],
                    'date fin' => $_POST['date_fin'],
                    'salaire' => $_POST['salaire_mensuel'],
                    'nb_heures' => $_POST['taux_horaire_hebdomadaire'],
                    'trvail_nuit' => isset($_POST['travail_nuit']) ? true : null,
                    'travail_wk' =>  isset($_POST['travail_wk']) ? true : null
                ];
                try {
                    if(empty($infos['poste']))
                        throw new Exception("Le champs poste doit être rempli !");
                    elseif(empty($infos['service']))
                        throw new Exception("Le champs service doit être rempli !");
                    elseif(empty($infos['type_de_contrat']))
                        throw new Exception("Le champs type de contrat doit être rempli !");
                    elseif(empty($infos['date debut']))
                        throw new Exception('Le champs date de début doit être rempli !');
                    elseif(empty($infos['salaire']))
                        throw new Exception('Le champs salaire doit être rempli !');
                    elseif(empty($infos['nb_heures']))
                        throw new Exception('Le champs taux horaire hebdomadaire doit être rempli !');

                } catch(Exception $e) {
                    forms_manip::error_alert($e);
                }
                
                try {
                    if(isset($_GET['cle_candidat'])) 
                        $candidats->createProposition($_GET['cle_candidat'], $infos);
                    else 
                        throw new Exception("Une erreur s'est produite. Clé candidat introuvable !");

                } catch(Exception $e) {
                    forms_manip::error_alert($e);
                }
                
                break;    

            case 'inscript-propositions-from-candidatures':
                break;    

            case 'reject-candidatures':
                echo "Méthode sélectionnée";
                $candidats->rejectCandidature($_GET['cle']);
                break;  
            
            case 'accept-candidatures': 
                break;    
            
            default: 
                throw new Exception ('Action inidentifiable');
        } 
    } catch(Exception $e) {
        forms_manip::error_alert($e);
    }


} elseif(isset($_SESSION['user_cle'])) {
    $home = new HomeController();
    $home->displayHome();
    echo "<script>console.log(\"Connecté en tant que " . $_SESSION['user_identifiant'] . "\");</script>";

} else {
    $c = new LoginController();
    $c->displayLogin();
}