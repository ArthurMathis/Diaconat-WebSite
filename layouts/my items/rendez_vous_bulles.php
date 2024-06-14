<div class="rendez_vous_bulle">
    <h2>Rendez-vous</h2>
    <div>
        <p>Recruteur : </p>
        <p><?= $item['utilisateur']; ?></p>
    </div>
    <div>
        <p>Programmé au : </p>
        <p classe="date"><?= $item['date']; ?></p>
    </div>
    <h3>Compte rendu</h3>
    <p><?= $item['description']; ?></p>
</div>