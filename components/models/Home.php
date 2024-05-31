<?php 

require_once(MODELS.DS.'Model.php');

class Home extends Model {
    public function getNontraiteeCandidature() {
        // On initialise la requête
        $request = "";

        // On lance la requête
        $result = $this->get_request($request, $params=[], true, true);

        // On retourne le rôle
        return $result;
    }
}

/*
SELECT nom, prenom, email, telephone
FROM `candidatures` as c
INNER JOIN candidats as i on c.Id_Candidats = i.Id
INNER JOin postes as p on c.Id_Postes = p.Id
INNER JOIN sources as s on c.Id_Sources = s.Id
*/