<?php 

require_once(MODELS.DS.'Model.php');
require_once(CLASSE.DS.'Utilisateurs.php');
require_once(CLASSE.DS.'Instants.php');

class LoginModel extends Model {
    public function connectUser($identifiant, $motdepasse) {
        // On cherche l'utilisateur dans la base de données
        $user = $this->verifyUser($identifiant, $motdepasse);
        
        // On récupère les données de l'utilisateur
        $_SESSION['user_cle']           = $user->getCle();
        $_SESSION['user_identifiant']   = $user->getIdentifiant();
        $_SESSION['user_email']         = $user->getEmail();
        $_SESSION['user_motdepasse']    = $user->getMotdepasse();
        $_SESSION['user_role']          = $user->getRole();

        // On enregistre les logs
        $this->writeLogs($_SESSION['user_cle'], "Connexion");
    }

    public function deconnectUser() {
        $this->writeLogs($_SESSION['user_cle'], 'Deconnexion');
        session_destroy();
    }


    // METHODES DE MANIPULATIONS DES UTILISATEURS //

    private function verifyUser($identifiant, $motdepasse): ?Utilisateurs{
        // On récupère les Utilisateurs
        $request = "SELECT * FROM Utilisateurs WHERE Identifiant_Utilisateurs = :nom";
        $params = [":nom" => $identifiant];
        $users = $this->get_request($request, $params, false, true);

        // On déclare les variables tampons
        $i = 0;
        $size = $users != null ? count($users) : 0;    
        $find = false;  

        // On fait défiler la table
        while($i < $size && !$find) {
            if($users[$i]["Identifiant_Utilisateurs"] == $identifiant && password_verify($motdepasse, $users[$i]["MotDePasse_Utilisateurs"])) {
                // On implémente find
                $find = true;

                // On construit notre Utilisateur
                try {
                    $user = new Utilisateurs(
                        $users[$i]['Identifiant_Utilisateurs'], 
                        $users[$i]['Nom_Utilisateurs'],
                        $users[$i]['Prenom_Utilisateurs'],
                        $users[$i]['Email_Utilisateurs'], 
                        $motdepasse, 
                        $users[$i]['Cle_Etablissements'],
                        $users[$i]['Cle_Roles']
                    );
                    $user->setcle($users[$i]['Id_Utilisateurs']);

                // On récupère les éventuelles erreurs 
                } catch(InvalideUtilisateurExceptions $e) {
                    forms_manip::error_alert($e);
                }

                // On retourne notre utilisateur, la connexion est validée
                return $user;
            } 
            // On implémnte l'index
            $i++;
        }
        // Utilisateur introuvé, on signale l'erreur
        if($i == $size) 
            throw new Exception("Aucun utilisateur correspondant");
    }
}