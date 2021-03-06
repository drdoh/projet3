<?php 
if(!isset($post)){
    if(!empty($_POST)){
        $title= $_POST['title'];
        $content=$_POST['content'];
        $chapter=$_POST['chapter'];
        $URL='?action=addpost';
        $img= '';
    }else{
    $title='';
    $content='';
    $chapter='';
    $URL='?action=addpost';
    $img='';
    }
}else{
    $title=$post->title();
    $content=$post->content();
    $chapter=$post->chapter();
    $URL='?action=updatepost&id='.$_GET['id'].'';
    $img='<img class="jumbotron" src="'.$post->img().'" style="width:100%;">';  
} 
ob_start();
?>
<section>
    <div class ="container">
        <p><a href="index.php">Retour à la liste des chapitres</a></p>
        <h1 class="m-4 text-center"> Redigez votre article </h1>
        <?php if(isset($message)){echo $message;}?>
            
        <div class="container my-auto">
            <form method="post" action="index.php<?=$URL?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="form-group col-8" >
                        <label class="h5" for="title">TITRE</label>
                        <input class="form-control" type="text" name="title"value='<?= $title ?>'>
                    </div>
                    <div class="form-group col-4">
                        <label class="h5" for="title">Chapitre n°:</label>
                        <input class="form-control" type="text" name="chapter"value='<?= $chapter ?>'>
                    </div>
                </div><br>   
                <textarea name="content" id="post">   
                    <?= $content ?>
                </textarea><br>
                <div class="d-flex justify-content-between">         
                    <button type="submit" class=" col-3 btn btn-primary h-50">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Enregistrer
                    </button>
                    <input class=" col-6 btn btn-primary h-50" type="file" name="img"/>
                </div >

                <div class="row">
                    <div class="m-5 col-8 mx-auto">
                        <?=$img?>
                    </div>
                </div>
            </form>    
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();

require('view/layout.php');
?>
