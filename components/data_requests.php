<?php 

function get_request($bdd, $sql, $data): ?array {
    // On vérifie l'intégrité des paramètres
    if(empty($bdd) || !$bdd instanceof PDO) 
        throw new Exception("La base de données doit être passée en paramètre !");
    elseif(empty($sql) || !is_string($sql)) 
        throw new Exception("La requête doit être passée en paramètre !");
    elseif(empty($data) || !is_array($data)) 
        throw new Exception("Les données de la requête doivent être passsée en paramètre !");

    // S'il n'y a pas d'erreurs, on lance la requête    
    else try{
        $query = $bdd->prepare($sql);
        $query->execute($data);

        // On récupère le résultat de la requête
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if(empty($result)) 
            throw new Exception("Erreur de récupération du type d'action");
        
        // On retourne le résultat de la requête 
        return $result;

    } catch(Exception $e){
        $_SESSION['erreur'] = $e;
        // On redirige la page
        header("Location: ../view/erreur.php");
        exit;
    } catch(PDOException $e){
        $_SESSION['erreur'] = $e;
        // On redirige la page
        header("Location: ../view/erreur.php");
        exit;
    }   
}

