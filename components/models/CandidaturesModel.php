<?php 

require_once(MODELS.DS.'Model.php');
require_once(CLASSE.DS.'Instants.php');
require_once(VIEWS.DS.'ErrorView.php');

class CandidaturesModel extends Model {
    public function getCandidatures() {
        // On initialise la requête
        $request = "SELECT  Statut_Candidatures AS Statut, 
        nom_candidats AS Nom, 
        prenom_candidats AS Prénom, 
        intitule_postes AS Poste,
        email_candidats AS Email, 
        telephone_candidats AS Téléphone, 
        intitule_sources AS Source, 
        Disponibilite_Candidats AS Disponibilité
        FROM `candidatures` as c
        INNER JOIN candidats as i on c.Cle_Candidats = i.Id_Candidats
        INNER JOin postes as p on c.Cle_Postes = p.Id_Postes
        INNER JOIN sources as s on c.Cle_Sources = s.Id_Sources";
    
        // On lance la requête
        $result = $this->get_request($request);
    
        // On retourne le rôle
        return $result;
    }

    public function inscriptCandidature($candidat=[], $candidatures=[]) {
        try {
            // On inscrit l'instant 
            $instant = $this->inscriptInstants()['Id_Instants'];
            // On récupère la clé du candidat 
            $candidat = $this->searchCandidat($candidat['nom'], $candidat['prenom'], $candidat['email'])['Id_Candidats'];
            // On récupère la source
            $source = $this->searchSource($candidatures["source"])['Id_Sources'];
            // On récupère le poste
            $poste = $this->searchPoste($candidatures["poste"])['Id_Postes'];

            // On ajoute l'action à la base de données
            $request = "INSERT INTO Candidatures (Statut_Candidatures, Cle_Candidats, Cle_Instants, Cle_Sources, Cle_Postes) 
                        VALUES (:statut, :candidat, :instant, :source, :poste)";
            $params = [
                ":statut" => 'non-traitee', 
                ":candidat" => $candidat, 
                ":instant" => $instant, 
                ":source" => $source, 
                ":poste" => $poste
            ];
        
        $this->post_request($request, $params);

        } catch (Exception $e) {
            $Error = new ErrorView();
            $Error->getErrorContent($e);
            exit;
        }
    }
    public function inscriptCandidat() {

    }

    protected function searchCandidat($nom, $prenom, $email) {
        // On récupère le candidats
        $request = "SELECT * FROM Candidats WHERE Nom_Candidats = :nom AND Prenom_Candidats = :prenom AND Email_Candidats = :email";
        $params = [
            ":nom" => $nom,
            ":prenom" => $prenom, 
            ":email" => $email
        ];
        $candidats = $this->get_request($request, $params, true, true);

        // On retourne sa clé
        return $candidats;
    }
    protected function searchSource($source) {
        // On initialise la requête
        if(is_numeric($source)) {
            $request = "SELECT * FROM sources WHERE Id_Sources = :Id";
            $params = ["Id" => $source];

        } elseif(is_string($source)) {
            $request = "SELECT * FROM roles WHERE Intitule_Sources = :Intitule";
            $params = ["Intitule" => $source];
        } else 
            throw new Exception("La saisie de la source est mal typée. Elle doit être un identifiant (entier positif) ou un echaine de caractères !");

        // On lance la requête
        $result = $this->get_request($request, $params, true, true);

        // On retourne le rôle
        return $result;
    }
    protected function searchPOste($poste) {
        // On initialise la requête
        if(is_numeric($poste)) {
            $request = "SELECT * FROM Postes WHERE Id_Postes = :Id";
            $params = ["Id" => $poste];

        } elseif(is_string($poste)) {
            $request = "SELECT * FROM roles WHERE Intitule_Postes = :Intitule";
            $params = ["Intitule" => $poste];
        } else 
            throw new Exception("La saisie du poste est mal typée. Il doit être un identifiant (entier positif) ou un echaine de caractères !");

        // On lance la requête
        $result = $this->get_request($request, $params, true, true);

        // On retourne le rôle
        return $result;
    }
}