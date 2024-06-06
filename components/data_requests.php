<?php 

function test_data_request($bdd, $sql, $data): bool {
    // On déclare une variable tampon
    $res = false;

    // On vérifie l'intégrité des paramètres
    if(empty($bdd) || !$bdd instanceof PDO) 
        throw new Exception("La base de données doit être passée en paramètre !");
    elseif(empty($sql) || !is_string($sql)) 
        throw new Exception("La requête doit être passée en paramètre !");
    elseif(empty($data) || !is_array($data)) 
        throw new Exception("Les données de la requête doivent être passsée en paramètre !");

    // On retourne le résultat
    else $res = true;
    return $res;
}

function get_request($bdd, $sql, $data, $unique, $present): ?array {
    // On vérifie le paramètre uniquue
    if(empty($unique) || !is_bool($unique)) 
        $unique = false;
    // On vérifie le paramètre uniquue
    if(empty($present) || !is_bool($present)) 
        $present = false;

    // On vérifie l'intégrité des paramètres
    if(test_data_request($bdd, $sql, $data)) try {
        // On prépare la requête
        $query = $bdd->prepare($sql);
        $query->execute($data);

        // On récupère le résultat de la requête
        if($unique) 
            $result = $query->fetch(PDO::FETCH_ASSOC);
        else 
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

        if($present && empty($result)) 
            throw new Exception("Requête: " . $sql ."\nAucun résultat correspondant");
        
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

function post_request($bdd, $sql, $data): bool {
    // On déclare une variable tampon
    $res = true;

    // On vérifie l'intégrité des paramètres
    if(!test_data_request($bdd, $sql, $data)) 
        $res = false;

    else try {
        // On prépare la requête
        $query = $bdd->prepare($sql);
        $query->execute($data);

    // On vérifie qu'il n'y a pas eu d'erreur lors de l'éxécution de la requête    
    } catch(PDOException $e){
        $_SESSION['erreur'] = $e;
        // On redirige la page
        header("Location: ../view/erreur.php");
        exit;
    } 

    // On retourne le résultat
    return $res;
}