<form class="big-form" method="post" action="index.php?candidats=inscript-propositions&cle_candidat=<?= $cle_candidat; ?>">
    <div class="form-container">
        <section>
            <h2>Emploi</h2>
            <input type="text" id="poste" name="poste" placeholder="Poste">
            <input type="text" id="service" name="service" placeholder="Services">
            <input type="text" id="type_contrat" name="type_contrat" placeholder="Type de contrats">
        </section>
        <section>
            <h2>Durée du contrat</h2>
            <div class="input-container">
                <label for="date_debut">Date de début</label>
                <input type="date" name="date_debut" id="date_debut">
            </div>
            <div class="input-container">
                <label for="date_fin">Date de fin</label>
                <input type="date" name="date_fin" id="date_fin">
            </div>
        </section>
        <section>
            <h2>Horaires et rémunérations</h2>
            <input type="number" id="salaire_mensuel" name="salaire_mensuel" placeholder="salaire mensuel">
            <input type="number" id="taux_horaire_hebdomadaire" name="taux_horaire_hebdomadaire" placeholder="taux horaire hebdomadaire">
            <div class="checkbox-liste">
                <div class="checkbox-item">
                    <label for="travail_nuit">Travail de nuit</label>
                    <input type="checkbox" id="travail_nuit" name="travail_nuit">
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="travail_wk" name="travail_wk"/>
                    <label for="travail_wk">Travail le week-end</label>
                </div>
            </div>
        </section>
        <section class="buttons_actions">
            <button type="submit" class="submit_button" value="new_user">Inscrire</button>
        </section>
    </div>
</form>
