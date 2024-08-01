<?php

require_once 'Controller.php';
/**
 * Class representing the login controller
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class LoginController extends Controller {
    /**
     * Class constructor
     */
    public function __construct() {
        $this->loadModel('LoginModel');
        $this->loadView('LoginView');
    }

    /**
     * Public method returning the login form
     *
     * @return void
     */
    function displayLogin() {
        return $this->View->getContent();
    }

    /**
     * Public method connecting one user to the application
     *
     * @param string $identifiant THe user's id (ex: name.f)
     * @param string $motdepasse The user's password
     * @return void
     */
    public function checkIdentification($identifiant, $motdepasse) {
        $this->Model->connectUser($identifiant, $motdepasse);
        alert_manipulation::alert([
            'title' => 'Connexion réussie',
            'msg' => 'Bienvene ' . strtoupper($_SESSION['user_nom']) . ' ' . forms_manip::nameFormat($_SESSION['user_prenom']),
            'direction' => 'index.php'
        ]);
    }
    /**
     * Public method disconnecting the current user to the application
     *
     * @return void
     */
    public function closeSession() {
        $this->Model->deconnectUser();
        alert_manipulation::alert([
            'title' => 'Déconnexion réussie',
            'msg' => 'A bientot !',
            'direction' => 'index.php'
        ]);
        // header('Location: index.php');
    }
}