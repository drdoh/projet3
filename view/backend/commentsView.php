<?php ob_start();
require('view/backend/commentOption/commentGlobOptionView.php'); ?>

<div class="container">
    <div class="row">
        <div class="col-sm "><br>
            

            <h2>Commentaires de l'article : <?=$post->title()?></h2><br>
            

            <p><a href="index.php">Retour à la liste des billets</a></p>

            <div class="row">
                <?=$commentGlobalOption;?>      
            </div><br>

            <ul class="list-group">

                <?php
                if(!empty($comments)){
                    foreach($comments as $comment) {
                        require('controler/backend/commentStatus.php');
                        require('view/backend/commentOption/commentIndivOptView.php');  
                ?>
                    <li class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="row ">
                            <div class="col-6">
                                <p><strong><?= $comment->author() ?></strong> le <?= $comment->comment_date()?></p>
                                <p><?= $comment->comment()?> </p>
                            </div>
                            <div class="col-2 align-self-center">
                                <?=$status?>
                            </div>
                        </div>

                        <div class="row">

                            <?=$commentOption;?>
                        
                        </div>
                    </li>

                <?php }}else{ ?>
                
                    <li class="list-group-item list-group-item-action flex-column align-items-start">
                        <p>Il n'y a pas de commentaire pour cette article</p>
                    </li>
            <?php } ?>
            </ul>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require('view/layout.php');
?>
