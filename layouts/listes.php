<section class="liste_items <?php echo $class; ?>">
    <div class="entete lignes">
        <h2><?php echo $titre; ?></h2>
        <h2><?php echo count($items); ?></h2>
    </div>
    <?php $keys = !empty($items) ? array_keys($items[0]) : 0; ?>
    <table>
        <thead>
            <tr><?php foreach($keys as $key) echo "<th>" . $key . "</th>"; ?></tr>
        </thead>
        <tbody>
            <?php 
                foreach($items as $row) {
                    echo "<tr>";
                    foreach($row as $cell) 
                        echo "<th>" . $cell . "</th>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</section>
<script src="layouts\assets\scripts\objects\InView.min.js"></script>
<script src="layouts\assets\scripts\objects\AnimateItems.js"></script>
<script>
    // On ajoute les animation de lignes
    const lignes = new AnimateItems('.lignes');
</script>