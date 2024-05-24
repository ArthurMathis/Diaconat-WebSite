<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diaconat - Gestionnaire de candidatures</title>

    <link rel="stylesheet" href="stylesheet/styles.css">
    <link rel="stylesheet" href="stylesheet/AnimateLignes.css">
    <link rel="stylesheet" href="stylesheet/index.css">
</head>
<body>
    <?php
        session_start();

        include ("objects/Utilisateurs.php");

        // On récupère la requête
        $user= $_SESSION['user'];
        if(empty($user)) {
            header("Location: view/connexion.php");
            exit;
        } 
    ?>
    <nav class="barre-de-navigation">
        <div id="menu-icon">
            <span></span>
        </div>
        <img src="assets/img/ico_diaconat_mulhouse.webp" alt="Logo de l'application">
        <div>
            <p id="calendrier"></p>
            <p id="horloge">00 : 00 : 00</p>
            <p class="user-info"><?php echo $user["identifiant"]; ?></p>
        </div>
    </nav>
    <form id="menu-deconnexion" method="POST" action="components/logout.php">
        <button type="submit" class="LignesHover">Se déconnecter</button>
    </form>
    <section id="menu">
        <a href="#">Candidatures</a>
        <a href="#">Employés</a>
        <a href="#">Besoins</a>
        <a href="#">Statistiques</a>
        <a href="#">Préférences</a>
    </section> 
    <content>
        <section>
            
        </section>
        <aside>
            <article>
                <div class="entete">
                    <h2>Candidatures en attente</h2>
                    <h2>6</h2>
                </div>
                <span class="ligne">
                <div class="container">
                    <div class="item">
                        <p>Mathis</p>
                        <p>Jean-françois</p>
                        <p>Accuponcteur-homéopathe</p>
                    </div>
                </div>
                <div class="boutons" <?php if($user["role"] == "Invite") echo "style=\"display: none; \""; ?>>
                    <a href="">+</a>
                    <a href="">Consulter</a>
                </div>
            </article>
            <article>
            <div class="entete">
                    <h2>Offres en cours</h2>
                    <h2>137</h2>
                </div>
                <span class="ligne">
                <div class="container">
                    <div class="item">
                        <p>Mathis</p>
                        <p>Arthur</p>
                        <p>Développeur full-stream_socket_accept</p>
                    </div>
                    <div class="item">
                        <p>Jean</p>
                        <p>Mark</p>
                        <p>Vendeur caissier</p>
                    </div>
                    <div class="item">
                        <p>Grégoire</p>
                        <p>Delatredetassigny</p>
                        <p>Ingénieur en automobile</p>
                    </div>
                </div>
                <div class="boutons" <?php if($user["role"] == "Invite") echo "style=\"display: none; \""; ?>>
                    <a href="">+</a>
                    <a href="">Consulter</a>
                </div>
            </article>
            <article>
            <div class="entete">
                    <h2>Rendez-vous</h2>
                    <h2>14</h2>
                </div>
                <span class="ligne">
                <div class="container">
                    <div class="item">
                        <p>Mathis</p>
                        <p>Jean-françois</p>
                        <p>Accuponcteur-homéopathe</p>
                    </div>
                    <div class="item">
                        <p>Deroussin</p>
                        <p>Esteban</p>
                        <p>Directeur artisique, UX/UI design</p>
                    </div>
                    <div class="item">
                        <p>Bouadballah</p>
                        <p>Narimane</p>
                        <p>Ingénieur en intelligence artificielle</p>
                    </div>
                </div>
                <div class="boutons" <?php if($user["role"] == "Invite") echo "style=\"display: none; \""; ?>>
                    <a href="">+</a>
                    <a href="">Consulter</a>
                </div>
            </article>
            <article>
            <div class="entete">
                    <h2>Employés</h2>
                    <h2>9782</h2>
                </div>
                <span class="ligne">
                <div class="container">
                    <div class="item">
                        <p>Mathis</p>
                        <p>Jean-françois</p>
                        <p>Accuponcteur-homéopathe</p>
                    </div>
                    <div class="item">
                        <p>Deroussin</p>
                        <p>Esteban</p>
                        <p>Directeur artisique, UX/UI design</p>
                    </div>
                    <div class="item">
                        <p>Bouadballah</p>
                        <p>Narimane</p>
                        <p>Ingénieur en intelligence artificielle</p>
                    </div>
                </div>
                <div class="boutons" <?php if($user["role"] == "Invite") echo "style=\"display: none; \""; ?>>
                    <a href="">+</a>
                    <a href="">Consulter</a>
                </div>
            </article>
        </aside>
    </content>

    <script src="scripts\Components\Date_Time.js"></script>
    <script src="scripts\View.js"></script>
</body>
</html>