<section class="liste_items<?php if(isset($classe) && !empty($classe)) echo $classe ?>" <?php if(isset($id) && !empty($id)): ?>id="<?= $id; ?>"<?php endif ?>>
    <div class="entete">
        <h2><?= $titre; ?></h2>
        <h3><?php 
            $size = empty($items) ? 0 : count($items); 
            echo $size;
        ?></h3>
    </div>
    <?php $keys = !empty($items) ? array_keys($items[0]) : ["Aucun élément"]; ?>
    <div class="table-wrapper">
        <table>
            <thead>
            <tr>
                <?php foreach($keys as $key): if($key != 'Cle') :?>
                    <th><?= $key ?></th>
                    <?php endif ?>
                <?php endforeach ?>   
            </tr>
            </thead>
            <tbody>
                <?php if($size > 0): ?>
                    <?php $i = 0; while($i < $size && $i < $nb_items_max): ?>
                        <tr>
                            <?php foreach($items[$i] as $key => $cell): if($key != 'Cle') :?>
                                <th><?= $cell ?></th>  
                                <?php endif ?>
                            <?php endforeach ?>
                        </tr>
                        <?php $i++; ?>
                    <?php endwhile ?>    
                <?php else : ?>    
                    <tr><th>Ce tableau est vide</th></tr>
                <?php endif ?>    
            </tbody>
        </table>
    </div>
</section>
<?php if(isset($items[0]['Cle'])): ?>
    <?php 
        $links = [];
        foreach($items as $row) array_push($links, $row['Cle']);   
    ?>
    <script>
        const rows = document.querySelectorAll('.liste_items .table-wrapper table tbody tr');
        const links = <?= json_encode($links); ?>;

        rows.forEach((obj, index) => {
            obj.addEventListener('click', () => {
                window.location.href = 'index.php?candidats=' + links[index];
            });
        });
    </script>
<?php endif ?>