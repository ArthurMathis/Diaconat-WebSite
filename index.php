<?php 

require_once('define.php');
require_once(COMPONENTS.DS.'AlertManipulation.php');
require_once(COMPONENTS.DS.'forms_manip.php');
require_once(CONTROLLERS.DS.'LoginController.php');
require_once(CONTROLLERS.DS.'HomeController.php');
require_once(CONTROLLERS.DS.'CandidaturesController.php');
require_once(CONTROLLERS.DS.'CandidatsController.php');
require_once(CONTROLLERS.DS.'PreferencesController.php');

// On démarre la session de l'utilisateur
session_start();

// On récupère les infos de connexion à la base de données
env_start();

include(COMMON.DS.'entete.php');

if(isset($_SESSION['first log in']) && $_SESSION['first log in'] == true) {
    // On libère la mémoire
    unset($_SESSION['first log in']);
    header('Location: index.php?preferences=edit-password');
    
} elseif(isset($_GET['login'])) {
    // On déclare le controller de connexions
    $login = new LoginController();

    // On sélectionne l'action
    switch($_GET['login']) {
        // On connecte l'utilisateur     
        case 'connexion' : 
            $erreur = "Erreur d'identification";
            try {
                // On récupère les données saisies
                $identifiant = $_POST["identifiant"];
                $motdepasse = $_POST["motdepasse"];
                
                // On vérifie leur intégrité
                if(empty($identifiant)) 
                    throw new Exception("Le champs identifiant doit être rempli !");
                elseif(empty($motdepasse)) 
                    throw new Exception("Le champs mot de passe doit être rempli !"); 
    
            // On récupère et retourne les éventuelles erreurs    
            } catch(Exception $e){
                forms_manip::error_alert([
                    'title' => $erreur,
                    'msg' => $e
                ]);
            }

            try {
                // On identifie l'utilisateur
                $login->checkIdentification($identifiant, $motdepasse);

            // On récupère les éventuelles erreurs    
            } catch(Exception $e) {
                forms_manip::error_alert([
                    'title' => $erreur,
                    'msg' => $e
                ]);
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

        default : 
            $c->displayLogin();
            break;
    }

} elseif(isset($_GET['candidatures'])) {
    // On déclare le controller de candidatures
    $candidatures = new CandidaturesController();

    // On sélectionne l'action
    switch($_GET['candidatures']) {
        // On affiche la page liste des candidatures
        case 'home' :
            $candidatures->dispayCandidatures();
            break; 

        // On affiche le formulaire 
        case 'saisie-nouveau-candidat' : 
            $candidatures->displaySaisieCandidat();
            break;

        // On affiche le formulaire d'inscription d'un candidat    
        case 'saisie-candidat' :   
            $candidatures->displayRechercheCandidat();
            break; 
            
        // On affiche le formulaire d'inscription d'une candidature    
        case 'saisie-candidature' : 
            $candidatures->displaySaisieCandidature();
            break;

        // On inscrit un nouveau candidat    
        case 'inscription-candidat' :     
            // On récupère les données du formulaire
            try {
                // On récupère le contenu du formulaire d'inscription
                $candidat = [
                    'nom' => forms_manip::nameFormat($_POST["nom"]), 
                    'prenom' => forms_manip::nameFormat($_POST["prenom"]), 
                    'email' => $_POST["email"], 
                    'telephone' => forms_manip::numberFormat($_POST["telephone"]), 
                    'adresse' => $_POST["adresse"],
                    'ville' => forms_manip::nameFormat($_POST["ville"]), 
                    'code_postal' => $_POST['code-postal']
                ];
                $diplomes = [
                    $_POST["diplome-1"], 
                    $_POST["diplome-2"], 
                    $_POST["diplome-3"]
                ];
                $aide               = $_POST["aide"];
                $visite_medicale    = $_POST["visite_medicale"];

            } catch(Exception $e) {
                forms_manip::error_alert([
                    'title' => "Erreur lors de l'inscription du candidat",
                    'msg' => $e
                ]);
            }

            // On vérifie l'intégrité des données
            try {    
                if(empty($candidat['nom'])) {
                    throw new Exception("Le champs nom doit être rempli par une chaine de caractères !");
                } elseif(empty($candidat['prenom'])) {
                    throw new Exception("Le champs prenom doit être rempli par une chaine de caractères !");
                } elseif(empty($candidat['email'])) {
                    throw new Exception("Le champs email doit être rempli par une chaine de caractères !");
                } elseif(empty($candidat['adresse'])) {
                    throw new Exception("Le champs adresse doit être rempli par une chaine de caractères !");
                } elseif(empty($candidat['ville'])) {
                    throw new Exception("Le champs ville doit être rempli par une chaine de caractères !");
                } elseif(empty($candidat['code_postal'])) {
                    throw new Exception("Le champs code postal doit être rempli par une chaine de caractères !");
                } 
            
            // On récupère les éventuelles erreurs    
            } catch(Exception $e) {
                forms_manip::error_alert([
                    'title' => "Erreur lors de l'inscription du candidat",
                    'msg' => $e
                ]);
            }

            // On test l'intégrité des diplômes
            foreach($diplomes as $d) 
                if(strlen($d) > 128) 
                forms_manip::error_alert([
                    'title' => "Erreur lors de l'inscription du candidat",
                    'msg' => "Le diplome" . $d ." est trop volumineux. Veuillez réécrire son intitulé en max 128 caractères."
                ]);

            // On génère le candidat        
            $candidatures->checkCandidat($candidat, $diplomes, $aide, $visite_medicale == 'true' ? true : false);
            break;

        // On inscrit une nouvelle candidature
        case 'inscription-candidature' :
            // On récupère les données du formulaire
            try { 
                // On récupère le contenu des champs
                $candidature = [
                    'poste'             => forms_manip::nameFormat($_POST["poste"]), 
                    'service'           => $_POST["service"], 
                    'type de contrat'   => $_POST["type_de_contrat"],
                    'disponibilite'     => $_POST["disponibilite"], 
                    'source'            => forms_manip::nameFormat($_POST["source"])
                ];

            // On récupère les éventuelles erreurs    
            } catch(Exception $e) {
                forms_manip::error_alert([
                    'title' => "Erreur lors de l'inscription de la candidature",
                    'msg' => $e
                ]);
            }

            // On vérifie l'intégrité des données  
            try {
                if(empty($candidature['poste'])) 
                    throw new Exception("Le champs poste doit être rempli par une chaine de caractères");
                elseif(empty($candidature['disponibilite'])) 
                    throw new Exception("Le champs disponibilité doit être rempli par une chaine de caractères");
                elseif(empty($candidature['source'])) 
                    throw new Exception("Le champs source doit être rempli par une chaine de caractères");

            // On récupère les éventuelles erreurs
            }  catch(Exception $e) {
                forms_manip::error_alert([
                    'title' => "Erreur lors de l'inscription de la candidature",
                    'msg' => $e
                ]);
            }
            
            // On récupère le candidat
            $candidat = $_SESSION['candidat'];
            $diplomes = isset($_SESSION['diplomes']) && !empty($_SESSION['diplomes']) ? $_SESSION['diplomes'] : null;
            $aide = isset($_SESSION['aide']) && !empty($_SESSION['aide']) ? $_SESSION['aide'] : null;

            // On génère la candidature
            $candidatures->createCandidature($candidat, $candidature, $diplomes, $aide);

            // Libérer la mémoire !!
            break;
    
        // On renvoie à la page d'accueil    
        default : 
            $candidatures->dispayCandidatures();
            break;
    }

} elseif(isset($_GET['candidats'])) {
    // On déclare le controller de candidats
    $candidats = new CandidatController();

    // On vérifie s'il s'agit d'une clé de candidat
    if(is_numeric($_GET['candidats'])) 
        $candidats->displayCandidat($_GET['candidats']);

    // Sinon, on sélectionne l'action
    else try { 
        switch($_GET['candidats']) {
            // On affiche la liste des candidats
            case 'home':
                $candidats->displayContent();
                break;

            // On retourne le formulaire d'ajout d'une candidature    
            case 'saisie-candidatures': 
                // On vérifie la présence de la clé candidat
                if(isset($_GET['cle_candidat']) && is_numeric($_GET['cle_candidat']))
                    $candidats->getSaisieCandidature($_GET['cle_candidat']);
                // On signale l'erreur    
                else 
                    throw new Exception("La clé candidat n'a pas pu être réceptionnée");
                break;
            
            // On retourne le formulaire d'ajout d'une proposition d'embauche    
            case 'saisie-propositions' :
                // On vérifie la présence de la clé candidat
                if(isset($_GET['cle_candidat']) && is_numeric($_GET['cle_candidat']))
                    $candidats->getSaisieProposition($_GET['cle_candidat']);
                // On signale l'erreur  
                else 
                    throw new Exception("La clé candidat n'a pas pu être réceptionnée");
                break;

            // On retourne le fomulaire d'ajout d'un contrat    
            case 'saisie-contrats':
                // On vérifie la présence de la clé candidat
                if(isset($_GET['cle_candidat']) && is_numeric($_GET['cle_candidat']))
                    $candidats->getSaisieContrats($_GET['cle_candidat']);
                // On signale l'erreur 
                else 
                    throw new Exception("La clé candidat n'a pas pu être récupérée !");
                break;

            // On retourne le formulaire d'ajout d'une proposition dans le cas où elle se construit à partir d'une candidature    
            case 'saisie-propositions-from-candidature':
                // On vérifie la présence de la clé candidature
                if(isset($_GET['cle_candidature']) && is_numeric($_GET['cle_candidature']))
                    $candidats->getSaisiePropositionFromCandidature($_GET['cle_candidature']);
                // On signale l'erreur 
                else 
                    throw new Exception("La clé n'a pas pu être détectée !");
                break;

            // On retounre le formulaire d'ajout d'une proposition dans le cas pù elle se construit à partir d'une candidature sans service
            case 'saisie-propositions-from-empty-candidature':
                // On vérifie la présence de la clé candidature
                if(isset($_GET['cle_candidature']) && is_numeric($_GET['cle_candidature']))
                    $candidats->getSaisiePropositionFromEmptyCandidature($_GET['cle_candidature']);
                // On signale l'erreur
                else 
                    throw new Exception("La clé n'a pas pu être détectée !");
                break;    

            // On affiche le formulaire d'ajout de rendez-vous    
            case 'saisie-rendez-vous':
                // On vérifie la présence
                if(isset($_GET['cle_candidat']))
                    $candidats->getSaisieRendezVous($_GET['cle_candidat']);
                // On signale 
                else 
                    throw new Exception("La clé candidat n'a pas pu être récupérée !");
                break;    
            
            // On inscrit une proposition
            case 'inscript-propositions':
                // On récupère les données du formulaire
                try {
                    $infos = [
                        'poste' => $_POST['poste'],
                        'service' => $_POST['service'],
                        'type_de_contrat' => $_POST['type_contrat'],
                        'date debut' => $_POST['date_debut'],
                    ];

                // On récupère les éventuelles erreurs     
                } catch(Exception $e) {
                    forms_manip::error_alert([
                        'title' => "Erreur lors de l'inscription de la proposition",
                        'msg' => $e
                    ]);
                }

                // On vérifie l'intégrité des données
                try {
                    if(empty($infos['poste']))
                        throw new Exception("Le champs poste doit être rempli !");
                    elseif(empty($infos['service']))
                        throw new Exception("Le champs service doit être rempli !");
                    elseif(empty($infos['type_de_contrat']))
                        throw new Exception("Le champs type de contrat doit être rempli !");
                    elseif(empty($infos['date debut']))
                        throw new Exception('Le champs date de début doit être rempli !');

                // On récupère les éventuelles erreurs        
                } catch(Exception $e) {
                    forms_manip::error_alert([
                        'title' => "Erreur lors de l'inscription de la proposition",
                        'msg' => $e
                    ]);
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

                // On test la présence de la clé candidat    
                if(isset($_GET['cle_candidat'])) 
                    $candidats->createProposition($_GET['cle_candidat'], $infos);
                // On signale l'erreur
                else 
                    throw new Exception("Clé candidat introuvable !");
                
                break; 

            // On inscrit une proposition construite à partir d'une candidature 
            case 'inscript-propositions-from-candidatures':
                // On récupère les informations
                try {
                    // On récupère les données du formulaire
                    $infos = [
                        'date debut' => $_POST['date_debut']
                    ];

                    // On vérifie l'intégrité des données
                    if(empty($infos['date debut']))
                        throw new Exception('Le champs date de début doit être rempli !');

                // On récupère l'éventuelle erreur        
                } catch(Exception $e) {
                    forms_manip::error_alert([
                        'title' => "Erreur lors de l'inscription de la proposition",
                        'msg' => $e
                    ]);
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

                // On test la présence de la clé candidature
                if(isset($_GET['cle_candidature'])) 
                    // On récupère la clé candidature    
                    $candidats->createPropositionFromCandidature($_GET['cle_candidature'], $infos);
                // On signale l'erreur
                else 
                    throw new Exception("Clé candidat introuvable !");
                break;    

            // On inscrit une proposition construite à partir d'une candidature sans service    
            case 'inscript-propositions-from-empty-candidatures':
                try {
                    // On récupère les données du formulaire
                    $infos = [
                        'service' => $_POST['service'],
                        'date debut' => $_POST['date_debut']
                    ];

                    // ON vérifie l'intégrité des données
                    if(empty($infos['service']))
                        throw new Exception("Le champs service doit être rempli !");
                    elseif(empty($infos['date debut']))
                        throw new Exception('Le champs date de début doit être rempli !');

                // On récupère les éventuelles erreurs        
                } catch(Exception $e) {
                    forms_manip::error_alert([
                        'title' => "Erreur lors de l'inscription de la proposition",
                        'msg' => $e
                    ]);
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

                // On test la présence de la clé candidature
                if(isset($_GET['cle_candidature'])) 
                    $candidats->createPropositionFromEmptyCandidature($_GET['cle_candidature'], $infos);
                // On signale l'erreur
                else 
                    throw new Exception("Clé candidat introuvable !");
                break;       

            // On refuse une candidature    
            case 'reject-candidatures':
                // On test la présence de la clé candidature
                if(isset($_GET['cle_candidature']) && !empty($_GET['cle_candidature']))
                    $candidats->rejectCandidature($_GET['cle_candidature']);
                // On signale l'erreur
                else 
                    throw new Exception("Clé de candidature est introuvable !");
                break;  
               
            // On refuse une proposition    
            case 'reject-propositions':
                // On test la présence de la clé contrat
                if(isset($_GET['cle_proposition']))
                    $candidats->rejectProposition($_GET['cle_proposition']);
                // On signale l'erreur
                else 
                    throw new Exception("Clé de proposition est introuvable !");
                break; 

            // On construit un contrat    
            case 'inscript-contrats':
                // On récupère les données du formulaire
                $infos = [
                    'poste' => $_POST['poste'],
                    'service' => $_POST['service'],
                    'type_de_contrat' => $_POST['type_contrat'],
                    'date debut' => $_POST['date_debut']
                ];

                // On vérifie l'intégrité des données
                try {
                    if(empty($infos['poste']))
                        throw new Exception("Le champs poste doit être rempli !");
                    elseif(empty($infos['service']))
                        throw new Exception("Le champs service doit être rempli !");
                    elseif(empty($infos['type_de_contrat']))
                        throw new Exception("Le champs type de contrat doit être rempli !");
                    elseif(empty($infos['date debut']))
                        throw new Exception('Le champs date de début doit être rempli !');

                // On récupère les éventuelles erreurs        
                } catch(Exception $e) {
                    forms_manip::error_alert([
                        'title' => "Erreur lors de l'inscription du contrat",
                        'msg' => $e
                    ]);
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

                // On test la présence de la clé candidat    
                if(isset($_GET['cle_candidat']))
                    $candidats->createContrat($_GET['cle_candidat'], $infos);
                // On signale l'erreur
                else 
                    throw new Exception("La clé candidat est inrouvale !");
                break;    

            // On construit un contrat depuis une proposition    
            case 'inscript-contrats-from-proposition':
                // On test la présence de la clé contrat
                if(isset($_GET['cle_proposition']))
                    $candidats->acceptProposition($_GET['cle_proposition']);
                // On signale l'erreur
                else 
                    throw new Exception("La clé de contrat est introuvable !");
                break; 

            // On construit un rendez-vous    
            case 'inscript-rendez-vous':
                // On récupère le formulaire
                $infos = [
                    'recruteur' => $_POST['recruteur'],
                    'etablissement' => $_POST['etablissement'],
                    'date' => $_POST['date'],
                    'time' => $_POST['time']
                ];

                // On vérifie l'intégrité des données
                try {
                    if(empty($infos['recruteur']))
                        throw new Exception("Le champs recruteur doit être rempli !");
                    elseif(empty($infos['etablissement']))
                        throw new Exception("Le champs etablissement doit être rempli !");
                    elseif(empty($infos['date']))
                        throw new Exception("Le champs date doit être rempli !");
                    elseif(empty($infos['time']))
                        throw new Exception("Le champs horaire doit être rempli !");

                // On récupère les éventuelles erreurs        
                } catch(Exception $e) {
                    forms_manip::error_alert([
                        'title' => "Erreur lors de l'inscription du rendez-vous",
                        'msg' => $e
                    ]);
                }

                // On test la présence de la clé candidat
                if(isset($_GET['cle_candidat']))
                    $candidats->createRendezVous($_GET['cle_candidat'], $infos);
                // On signale l'erreur
                else 
                    throw new Exception("La clé candidat est inrouvale !");

                break;   
                
            // On ajoute une démission à un contrat
            case 'demission':
                // On test la présence de la clé contrat
                if(isset($_GET['cle_contrat']))
                    $candidats->demissioneContrat($_GET['cle_contrat']);
                // On sigale l'erreur
                else 
                    throw new Exception("La clé de contrat est introuvable !");
                break; 
                
            // On affiche le formulaire de mise-à-jour de la notation d'unn candidat    
            case 'edit-notation':
                // On test la présence de la clé candidat
                if(isset($_GET['cle_candidat']))
                    $candidats->getEditNotation($_GET['cle_candidat']);
                // On signale l'erreur
                else 
                    throw new Exception("La clé candidat est introuvable !");
                break;  
            // On affiche le formulaire de mise-à-jour ds données d'un cadidat
            case 'edit-candidat':
                // On test la présence de la clé candidat
                if(isset($_GET['cle_candidat']))
                    $candidats->getEditCandidat($_GET['cle_candidat']);
                // On signale l'erreur
                else 
                    throw new Exception("La clé candidat est introuvable !");
                break;  
            
            // On met-à-jour la notation d'un candidat
            case 'update-notation':
                // On vé'rifie l'intégrité des données
                try {
                    $notation = [
                        'notation' => max($_POST['notation']),
                        'a' => isset($_POST['a']) ? 1 : 0,
                        'b' => isset($_POST['b']) ? 1 : 0,
                        'c' => isset($_POST['c']) ? 1 : 0,
                        'description' => $_POST['description']
                    ];

                // On récupère les éventuelles erreurs    
                } catch(Exception $e) {
                    forms_manip::error_alert([
                        'title' => "Erreur lors de la mise-à-jour du candidat",
                        'msg' => $e
                    ]);
                }

                // On tets la présence de la clé candidat
                if(isset($_GET['cle_candidat']))
                    $candidats->updateNotation($_GET['cle_candidat'], $notation);
                // On signale l'erreur
                else 
                    throw new Exception("La clé candidat est introuvable !");
                break;  
                
            // On met-à-jour les données d'un candidat
            case 'update-candidat':
                // On récupère les donnnées du formulaire
                try {
                    $candidat = [
                        'nom' => forms_manip::nameFormat($_POST['nom']),
                        'prenom' => forms_manip::nameFormat($_POST['prenom']), 
                        'email' => $_POST['email'], 
                        'telephone' => forms_manip::numberFormat($_POST['telephone']), 
                        'adresse' => $_POST['adresse'], 
                        'ville' => forms_manip::nameFormat($_POST['ville']), 
                        'code-postal' => $_POST['code-postal'], 
                        'diplome' => [
                            $_POST["diplome-1"], 
                            $_POST["diplome-2"], 
                            $_POST["diplome-3"]
                        ], 
                        'aide' => $_POST['aide']
                    ];

                // On récupère les éventuelles erreurs
                } catch(Exception $e) {
                    forms_manip::error_alert([
                        'title' => "Erreur lors de la mise-à-jour du candidat",
                        'msg' => $e
                    ]);
                }

                // On tets la présence de la clé candidat
                if(isset($_GET['cle_candidat']) && !empty($_GET['cle_candidat']) && is_numeric($_GET['cle_candidat']))
                    $candidats->updateCandidat($_GET['cle_candidat'], $candidat);
                // On signale l'erreur
                else 
                    throw new Exception("Impossible de modifier la notation du candidat, clé candidat est introuvable !");
                break;  
                
            // On annule un rendez-vous    
            case 'delete-rendez-vous': 
                // On vérifie l'intégrité des données
                try {
                    if(!isset($_GET['cle_candidat']) || empty($_GET['cle_candidat']) || !is_numeric($_GET['cle_candidat']))
                        throw new Exception("Erreur lors de l'annulation du rendez-vous. La clé candidat doit être un nombre entier positif !");
                    elseif(!isset($_GET['cle_utilisateur']) || empty($_GET['cle_utilisateur']) || !is_numeric($_GET['cle_utilisateur']))
                        throw new Exception("Erreur lors de l'annulation du rendez-vous. La clé utilisateur doit être un nombre entier positif !");
                    elseif(!isset($_GET['cle_instant']) || empty($_GET['cle_instant']) || !is_numeric($_GET['cle_instant']))
                        throw new Exception("Erreur lors de l'annulation du rendez-vous. La clé instanbt doit être un nombre entier positif !");

                // On récupère les éventuelles erreurs        
                } catch(Exception $e) {
                    forms_manip::error_alert([
                        'title' => "Erreur lors de la suppression du rendez-vous",
                        'msg' => $e
                    ]);
                }

                // On annule le rendez-vous
                $candidats->annulationRendezVous($_GET['cle_candidat'], $_GET['cle_utilisateur'], $_GET['cle_instant']);
                break;    
            
            // L'action n'a pas pu être identifiée    
            default: 
                throw new Exception("L'action n'a pas pu être identifiée !");
        } 

    // On récupère les éventuelles erreurs    
    } catch(Exception $e) {
        forms_manip::error_alert([
            'title' => "Erreur lors de la redirection de la page",
            'msg' => $e
        ]);
    } 


} elseif(isset($_GET['preferences'])) {
    // On déclare le controller de préférences
    $preferences = new PreferencesController();

    // On sélectionne l'action
    switch($_GET['preferences']) {
        // On affiche la page d'accueil
        case 'home':
            $preferences->display(); 
            break;    

        // On affiche le formulaire de mise-à-jour du mot de passe    
        case 'edit-password':
            $preferences->displayEdit();
            break; 
            
        // On met-à-jour le mot de passe de l'utilisateur    
        case 'update-password':
            // On vérifie l'intégrité des données du formulaire
            try {
                if(empty($_POST['password']) || empty($_POST['new-password']) || empty($_POST['confirmation']))
                    throw new Exception('Erreur lors de la mise à jour du mot de passe. Tous les champs doivent être rempli pour mettre le mot de passe à jour !');
                elseif($_POST['new-password'] != $_POST['confirmation'])
                    throw new Exception('Erreur lors de la mise à jour du mot de passe. Le nouveau mot de passe et sa confirmation doivent être identiques !');

            // On récupère les éventuelles erreurs        
            } catch(Exception $e) {
                forms_manip::error_alert("Erreur lors de la mise-à-jour du mot de passe", $e);
            }

            // On met-à-jour le mot de passe
            $preferences->updatePassword($_POST['password'], $_POST['new-password']);
            break;    
   
        // On affiche la liste des utilisateurs
        case 'liste-utilisateurs':
            $preferences->displayUtilisateurs();
            break;

        // On affiche le formulaire d'ajout d'utilisateurs
        case 'saisie-utilisateur':
            $preferences->displaySaisieUtilisateur();
            break;    

        // On inscrit un nouvel utilisateur
        case 'inscription-utilisateur':
            // On récupère les données du formulaire
            try {
                $infos = [
                    'identifiant' => $_POST['identifiant'],
                    'nom' => $_POST['nom'],
                    'prenom' => $_POST['prenom'],
                    'email' => $_POST['email'],
                    'etablissement' => $_POST['etablissement'],
                    'role' => $_POST['role']
                ];
                
                if(empty($infos['identifiant']))
                    throw new Exception("Erreur lors de la récupération des données. Le champs identifiant doit être rempli.");
                elseif(empty($infos['nom']))
                    throw new Exception("Erreur lors de la récupération des données. Le champs nom doit être rempli.");
                elseif(empty($infos['prenom']))
                    throw new Exception("Erreur lors de la récupération des données. Le champs prenom doit être rempli.");
                elseif(empty($infos['email']))
                    throw new Exception("Erreur lors de la récupération des données. Le champs email doit être rempli.");
                    elseif(empty($infos['etablissement']))
                    throw new Exception("Erreur lors de la récupération des données. Le champs étabissement doit être rempli.");
                elseif(empty($infos['role']))
                    throw new Exception("Erreur lors de la récupération des données. Le champs role doit être rempli.");

            // On récupère les éventuelles erreurs        
            } catch(Exception $e) {
                forms_manip::error_alert("Erreur lors de l'incription du nouvel utilisateur", $e);
            }

            // On génère le nouvel utilisateur
            $preferences->createUtilisateur($infos);
            break;    

        // On affiche la liste des nouveaux utilisateurs
        case 'liste-nouveaux-utilisateurs':
            $preferences->displayNouveauxUtilisateurs();
            break;    
            
        // On affiche l'historique de connexions des utilisateurs
        case 'connexion-historique':
            $preferences->displayConnexionHistorique();
            break;  
            
        // On affiche l'historique d'actions des utilisateurs
        case 'action-historique':
            $preferences->displayActionHistorique();
            break;    

        // On affiche la liste des postes de la fondation    
        case 'liste-postes':
            $preferences->displayPostes();
            break;

        // On affiche le formulaire d'ajout de poste    
        case 'saisie-poste':
            $preferences->displaySaisiePoste();
            break;    

        // On inscrit un nouveau poste
        case 'inscription-poste':
            // On récupère les informations du formulaire
            try {
                $infos = [
                    'poste' => $_POST['poste'],
                    'description' => $_POST['description']
                ];
                
                if(empty($infos['poste']))
                    throw new Exception("Erreur lors de l'inscription du poste. Le champs poste doit être rempli !");
                if(empty($infos['description']))
                    throw new Exception("Erreur lors de l'inscription du poste. Le champs description doit être rempli !");

            } catch(Exception $e) {
                forms_manip::error_alert("Erreur lors de l'inscription du nouveau poste", $e);
            }

            $preferences->createPoste($infos);
            break;

        // On affiche la liste des services de la fondation
        case 'liste-services':
            $preferences->displayServices();
            break;

        // On affiche le formulaire d'ajout de service
        case 'saisie-service': 
            $preferences->displaySaisieService();
            break;

        // On inscrit un nouveau service
        case 'inscription-service':
            try {
                $service = $_POST['service'];
                $etablissement = $_POST['etablissement'];
      
                if(empty($service) || empty($etablissement))
                    throw new Exception("Les champs service est établissements doivent être remplis !");

            } catch (Exception $e) {
                forms_manip::error_alert("Erreur lors de l'inscription dunnouveau service", $e);
            }

            $preferences->createService($service, $etablissement);
            break;   
            
        // On affiche la liste des établissements de la fondation
        case 'liste-etablissements':
            echo 'listes des établissements';
            break;
            
        // On affiche la listes des pôles de la fondation
        case 'liste-poles':
            echo 'listes des pôles';
            break;
            
        // On affiche la liste des diplômes    
        case 'diplome': 
            echo 'Diplômes';
            break;
            
        // On affiche les listes des autres données de la base de données (types de contrats, aides au recrutement, sources)    
        case 'autres':
            echo 'autres';
            break;    

        default: 
            throw new Exception("L'action n'a pas pu être identifiée !");
    }

} elseif(isset($_SESSION['user_cle'])) {
    // On affiche la page d'accueil du site
    $home = new HomeController();
    $home->displayHome();

} else {
    // On affiche le formulaire de connexion
    $c = new LoginController();
    $c->displayLogin();
}

include(COMMON.DS.'footer.php');