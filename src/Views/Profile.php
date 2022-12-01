<?php
use Formation\MonApp\Model\Users;

echo '<h2>'.$title.'</h2>';
?>
<!-- Boutton retour accueil -->
<a href='index.php' class="submit_back">< Retour à l'accueil</a>

<!-- Bloc 1 : Coordonées -->
<div class="card">
    <h3>Vos coordonnées</h3>
    <form action="" method="POST">
        <label for="">Nom :</label>
        <input type="text" name="nom" class= 'form_item' value="<?= $_SESSION['nom'] ?>">
        
        <label for="">Prénom :</label>
        <input type="text" name="prenom" class= 'form_item' value="<?= $_SESSION['prenom'] ?>">
    
        <label for="">Adresse e-mail :</label>
        <input type="text" name="mail" class= 'form_item' value="<?= $_SESSION['mail'] ?>">

        <input type="submit" name="submit" class = 'submit' value="Modifier">
    </form>
</div>

<!-- Bloc 2 : Avatar -->
<div class="card">
    <h3>Votre avatar</h3>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="card_dwl">
            <!-- Fonction : update de l'avatar -->
            <img class="avatar" src="
            <?php
            $avatar = Users::getSession('users' ,$_SESSION['id']);
            foreach($avatar[0] as $key => $value){
                if($key === 'avatar'){
                    $avatar = $value;
                }
            }
            echo 'upload/'.$_SESSION['id'].'/album/'.$avatar;
            ?>
            " alt="">
            <input type="file" name="file" class= 'form_item'>
        </div>
            <input type="submit" name="avatar" class = 'submit' value="Modifier">
    </form>
</div>

<!-- Delete : user -->
<a class='erreur erreur--Secondary btndel' href="index.php?page=&delete=1">Supprimer mon profil</a>

<!-- Fonction : window alert confirmation delete -->
<script type="text/javascript">
    const btn=document.querySelector('.btndel');
    btn.addEventListener('click', function(){
        event.preventDefault();
        var val = confirm("Etes-vous sûr de vouloir supprimer votre compte?");
            if( val == true ) {
                window.location = "index.php?page=&delete=1";
            }
    })
</script>

<!-- Boutton retour accueil -->
<a href='index.php' class="submit_back">< Retour à l'accueil</a>

