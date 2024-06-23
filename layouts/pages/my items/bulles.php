<article class="bulles">
    <h2><?= $titre; ?></h2>
    <?php if(!empty($items)): $size = count($items); ?>
        <p><?= $size;?> nb items</p>
        <?php $keys = array_keys($items[0]); ?>
        <div class="bulle-container">
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
            <div class="boutons">
                <a href="">Consulter</a>
                <div class="fleche">
                    <span></span>
                </div>
            </div>
        </div>
    <?php else : ?>
        <p>Aucun élément</p>
    <?php endif ?>
</article>
