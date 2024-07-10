<?php 

require_once('define.php');
require_once(CONTROLLERS.DS.'LoginController.php');
require_once(CONTROLLERS.DS.'HomeController.php');
require_once(CONTROLLERS.DS.'CandidaturesController.php');
require_once(CONTROLLERS.DS.'CandidatsController.php');
require_once(CONTROLLERS.DS.'UtilisateursController.php');
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
            case 'home':
                $candidats->displayContent();
                break;

            case 'saisie-candidatures': 
                if(isset($_GET['cle_candidat']) && is_numeric($_GET['cle_candidat']))
                    $candidats->getSaisieCandidature($_GET['cle_candidat']);
                else 
                    throw new Exception("La clé candidat n'a pas pu être réceptionnée");
                break;
            
            case 'saisie-propositions' :
                if(isset($_GET['cle_candidat']) && is_numeric($_GET['cle_candidat']))
                    $candidats->getSaisieProposition($_GET['cle_candidat']);
                else 
                    throw new Exception("La clé candidat n'a pas pu être réceptionnée");
                break;

            case 'saisie-contrats':
                if(isset($_GET['cle_candidat']))
                    $candidats->getSaisieContrats($_GET['cle_candidat']);
                else 
                    throw new Exception("La clé candidat n'a pas pu être récupérée !");
                break;

            case 'saisie-propositions-from-candidature':
                if(isset($_GET['cle_candidature']) && is_numeric($_GET['cle_candidature']))
                    $candidats->getSaisiePropositionFromCandidature($_GET['cle_candidature']);
                else 
                    throw new Exception("La clé n'a pas pu être détectée !");
                break;

            case 'saisie-propositions-from-empty-candidature':
                if(isset($_GET['cle_candidature']) && is_numeric($_GET['cle_candidature']))
                    $candidats->getSaisiePropositionFromEmptyCandidature($_GET['cle_candidature']);
                else 
                    throw new Exception("La clé n'a pas pu être détectée !");
                break;    

            case 'saisie-rendez-vous':
                if(isset($_GET['cle_candidat']))
                    $candidats->getSaisieRendezVous($_GET['cle_candidat']);
                else 
                    throw new Exception("La clé candidat n'a pas pu être récupérée !");
                break;    
            
            case 'inscript-propositions':
                // On récupère les données du formulaire
                $infos = [
                    'poste' => $_POST['poste'],
                    'service' => $_POST['service'],
                    'type_de_contrat' => $_POST['type_contrat'],
                    'date debut' => $_POST['date_debut'],
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

                } catch(Exception $e) {
                    forms_manip::error_alert($e);
                }

                // On ajoute les champs optionnel
                if(!empty($_POST['date_fin']))
                    $infos['date fin'] = $_POST['date_fin'];
                if(!empty($_POST['salaire_mensuel']))
                    $infos['salaire'] = intval($_POST['salaire_mensuel']);
                if(!empty($_POST['taux_horaire_hebdomadaire'])) 
                    $infos['taux horaire'] = $_POST['taux_horaire_hebdomadaire'];
                if(isset($_POST['travail_nuit']))
                    $infos['travail nuit'] = true;
                if(isset($_POST['travail_wk']))
                    $infos['travail nuit'] = true;

                if(isset($_GET['cle_candidat'])) 
                    $candidats->createProposition($_GET['cle_candidat'], $infos);
                else 
                    throw new Exception("Une erreur s'est produite. Clé candidat introuvable !");
                
                break; 

            case 'inscript-propositions-from-candidatures':
                try {
                    // On récupère les données du formulaire
                    $infos = [
                        'date debut' => $_POST['date_debut']
                    ];

                    if(empty($infos['date debut']))
                        throw new Exception('Le champs date de début doit être rempli !');

                } catch(Exception $e) {
                    forms_manip::error_alert($e);
                }

                // On ajoute les champs optionnel
                if(!empty($_POST['date_fin']))
                    $infos['date fin'] = $_POST['date_fin'];
                if(!empty($_POST['salaire_mensuel']))
                    $infos['salaire'] = intval($_POST['salaire_mensuel']);
                if(!empty($_POST['taux_horaire_hebdomadaire'])) 
                    $infos['taux horaire'] = $_POST['taux_horaire_hebdomadaire'];
                if(isset($_POST['travail_nuit']))
                    $infos['travail nuit'] = true;
                if(isset($_POST['travail_wk']))
                    $infos['travail nuit'] = true;

                // On récupère la clé candidature
                if(isset($_GET['cle_candidature'])) 
                    $candidats->createPropositionFromCandidature($_GET['cle_candidature'], $infos);
                else 
                    throw new Exception("Une erreur s'est produite. Clé candidat introuvable !");
                break;    

            case 'inscript-propositions-from-empty-candidatures':
                try {
                    // On récupère les données du formulaire
                    $infos = [
                        'service' => $_POST['service'],
                        'date debut' => $_POST['date_debut']
                    ];

                    if(empty($infos['service']))
                        throw new Exception("Le champs service doit être rempli !");
                    elseif(empty($infos['date debut']))
                        throw new Exception('Le champs date de début doit être rempli !');

                } catch(Exception $e) {
                    forms_manip::error_alert($e);
                }

                // On ajoute les champs optionnel
                if(!empty($_POST['date_fin']))
                    $infos['date fin'] = $_POST['date_fin'];
                if(!empty($_POST['salaire_mensuel']))
                    $infos['salaire'] = intval($_POST['salaire_mensuel']);
                if(!empty($_POST['taux_horaire_hebdomadaire'])) 
                    $infos['taux horaire'] = $_POST['taux_horaire_hebdomadaire'];
                if(isset($_POST['travail_nuit']))
                    $infos['travail nuit'] = true;
                if(isset($_POST['travail_wk']))
                    $infos['travail nuit'] = true;

                // On récupère la clé candidature
                if(isset($_GET['cle_candidature'])) 
                    $candidats->createPropositionFromEmptyCandidature($_GET['cle_candidature'], $infos);
                else 
                    throw new Exception("Une erreur s'est produite. Clé candidat introuvable !");
                break;       

            case 'reject-candidatures':
                if(isset($_GET['cle_candidature']) && !empty($_GET['cle_candidature']))
                    $candidats->rejectCandidature($_GET['cle_candidature']);
                else 
                    throw new Exception("Impossible de refuser la candidature, clé de candidature est introuvable !");
                break;  
               
            case 'reject-propositions':
                if(isset($_GET['cle_proposition']))
                    $candidats->rejectProposition($_GET['cle_proposition']);
                else 
                    throw new Exception("Impossible de refuser la proposition, clé de proposition est introuvable !");
                break; 

            case 'inscript-contrats':
                // On récupère les données du formulaire
                $infos = [
                    'poste' => $_POST['poste'],
                    'service' => $_POST['service'],
                    'type_de_contrat' => $_POST['type_contrat'],
                    'date debut' => $_POST['date_debut']
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

                } catch(Exception $e) {
                    forms_manip::error_alert($e);
                }

                // On ajoute les champs optionnel
                if(!empty($_POST['date_fin']))
                    $infos['date fin'] = $_POST['date_fin'];
                if(!empty($_POST['salaire_mensuel']))
                    $infos['salaire'] = intval($_POST['salaire_mensuel']);
                if(!empty($_POST['taux_horaire_hebdomadaire'])) 
                    $infos['taux horaire'] = $_POST['taux_horaire_hebdomadaire'];
                if(isset($_POST['travail_nuit']))
                    $infos['travail nuit'] = true;
                if(isset($_POST['travail_wk']))
                    $infos['travail nuit'] = true;

                if(isset($_GET['cle_candidat']))
                    $candidats->createContrat($_GET['cle_candidat'], $infos);
                else 
                    throw new Exception("Impossible d'inscrire le contrat. La clé candidat est inrouvale !");
                break;    

            case 'inscript-contrats-from-proposition':
                if(isset($_GET['cle_proposition']))
                    $candidats->acceptProposition($_GET['cle_proposition']);
                else 
                    throw new Exception("Impossible d'inscrire le contrat, clé de contrat est introuvable !");
                break; 

            case 'inscript-rendez-vous':
                // On récupère le formulaire
                $infos = [
                    'recruteur' => $_POST['recruteur'],
                    'etablissement' => $_POST['etablissement'],
                    'date' => $_POST['date'],
                    'time' => $_POST['time']
                ];

                try {
                    if(empty($infos['recruteur']))
                        throw new Exception("Le champs recruteur doit être rempli !");
                    elseif(empty($infos['etablissement']))
                        throw new Exception("Le champs etablissement doit être rempli !");
                    elseif(empty($infos['date']))
                        throw new Exception("Le champs date doit être rempli !");
                    elseif(empty($infos['time']))
                        throw new Exception("Le champs horaire doit être rempli !");

                } catch(Exception $e) {
                    forms_manip::error_alert($e);
                }

                if(isset($_GET['cle_candidat']))
                    $candidats->createRendezVous($_GET['cle_candidat'], $infos);
                else 
                    throw new Exception("Impossible d'inscrire le contrat. La clé candidat est inrouvale !");

                break;   
                
            case 'demission':
                if(isset($_GET['cle_contrat']))
                    $candidats->demissioneContrat($_GET['cle_contrat']);
                else 
                    throw new Exception("Impossible de renseigner la démission, clé de contrat est introuvable !");
                break; 
                
            case 'edit-notation':
                if(isset($_GET['cle_candidat']))
                    $candidats->getEditNotation($_GET['cle_candidat']);
                else 
                    throw new Exception("Impossible de modifier la notation du candidat, clé candidat est introuvable !");
                break;  

            case 'edit-candidat':
                if(isset($_GET['cle_candidat']))
                    $candidats->getEditCandidat($_GET['cle_candidat']);
                else 
                    throw new Exception("Impossible de modifier la notation du candidat, clé candidat est introuvable !");
                break;  
                
            case 'update-notation':
                try {
                    $notation = [
                        'notation' => max($_POST['notation']),
                        'a' => isset($_POST['a']) ? 1 : 0,
                        'b' => isset($_POST['b']) ? 1 : 0,
                        'c' => isset($_POST['c']) ? 1 : 0,
                        'description' => $_POST['description']
                    ];
                } catch(Exception $e) {
                    forms_manip::error_alert($e);
                }

                if(isset($_GET['cle_candidat']))
                    $candidats->updateNotation($_GET['cle_candidat'], $notation);
                else 
                    throw new Exception("Impossible de modifier la notation du candidat, clé candidat est introuvable !");
                break;  
                
            case 'update-candidat':
                try {
                    $candidat = [
                        'nom' => $_POST['nom'],
                        'prenom' => $_POST['prenom'], 
                        'email' => $_POST['email'], 
                        'telephone' => $_POST['telephone'], 
                        'adresse' => $_POST['adresse'], 
                        'ville' => $_POST['ville'], 
                        'code-postal' => $_POST['code-postal'], 
                        'diplome' => [
                            $_POST["diplome-1"], 
                            $_POST["diplome-2"], 
                            $_POST["diplome-3"]
                        ], 
                        'aide' => $_POST['aide']
                    ];

                } catch(Exception $e) {
                    forms_manip::error_alert($e);
                }

                if(isset($_GET['cle_candidat']))
                    $candidats->updateCandidat($_GET['cle_candidat'], $candidat);
                else 
                    throw new Exception("Impossible de modifier la notation du candidat, clé candidat est introuvable !");
                break;    
            
            default: 
                throw new Exception("L'action n'a pas pu être identifiée !");
        } 
    } catch(Exception $e) {
        forms_manip::error_alert($e);
    } 


} elseif(isset($_GET['utilisateurs'])) {
    $utilisateur = new UtilisateurController();

    switch($_GET['utilisateurs']) {
        case 'home':
            $utilisateur->displayUtilisateurs();
            break;

        case 'logs':
            $utilisateur->displayHistorique();
            break;

        case 'saisie-inscription':
            $utilisateur->displaySaisieUtilisateur();
            break;

        case 'inscription':
            try {
                $infos = [
                    'identifiant' => $_POST['identifiant'],
                    'nom' => $_POST['nom'],
                    'prenom' => $_POST['prenom'],
                    'email' => $_POST['email'],
                    'mot de passe' => $_POST['motdepasse'],
                    'confirmation' => $_POST['confirmation'],
                    'etablissement' => $_POST['etablissement'],
                    'role' => $_POST['role']
                ];
                
                if(empty($infos['identifiant']))
                    throw new Exception("Erreyur lors de la récupération des données. Le champs identifiant doit être rempli.");
                elseif(empty($infos['nom']))
                    throw new Exception("Erreyur lors de la récupération des données. Le champs nom doit être rempli.");
                elseif(empty($infos['prenom']))
                    throw new Exception("Erreyur lors de la récupération des données. Le champs prenom doit être rempli.");
                elseif(empty($infos['email']))
                    throw new Exception("Erreyur lors de la récupération des données. Le champs email doit être rempli.");
                elseif(empty($infos['mot de passe']))
                    throw new Exception("Erreyur lors de la récupération des données. Le champs mot de passe doit être rempli.");
                elseif(empty($infos['confirmation']))
                    throw new Exception("Erreyur lors de la récupération des données. Le champs confirmation doit être rempli.");
                    elseif(empty($infos['etablissement']))
                    throw new Exception("Erreyur lors de la récupération des données. Le champs étabissement doit être rempli.");
                elseif(empty($infos['role']))
                    throw new Exception("Erreyur lors de la récupération des données. Le champs role doit être rempli.");
                elseif($infos['mot de passe'] != $infos['confirmation'])
                    throw new Exception("Erreyur lors de la récupération des données. Le champs mot de passe doit être identique au champs confirmation.");

            } catch(Exception $e) {
                forms_manip::error_alert($e);
            }

            $utilisateur->createUtilisateur($infos);
            
            break;    
            
        default: 
            $utilisateur->displayUtilisateurs();
    }

} elseif(isset($_SESSION['user_cle'])) {
    $home = new HomeController();
    $home->displayHome();
    echo "<script>console.log(\"Connecté en tant que " . $_SESSION['user_identifiant'] . "\");</script>";

} else {
    $c = new LoginController();
    $c->displayLogin();
}