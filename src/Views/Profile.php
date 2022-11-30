<?php
use Formation\MonApp\Model\Users;
echo '<h2>'.$title.'</h2>';
?>

<a href='index.php' class="submit_back">< Retour à l'accueil</a>
<div class="card">
    <h3>Vos coordonnées</h3>
    <form action="" method="POST">
        <label for="">Nom :</label>
        <input type="text" name="nom" class= 'form_item' value="<?php echo $_SESSION['nom'] ?>">
        
        <label for="">Prénom :</label>
        <input type="text" name="prenom" class= 'form_item' value="<?php echo $_SESSION['prenom'] ?>">
    
        <label for="">Adresse e-mail :</label>
        <input type="text" name="mail" class= 'form_item' value="<?php echo $_SESSION['mail'] ?>">

        <input type="submit" name="submit" class = 'submit' value="Modifier">
    </form>
</div>
<div class="card">
    <h3>Votre avatar</h3>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="card_dwl">
            <img class="img_pro" src="
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
<a href='index.php' class="submit_back">< Retour à l'accueil</a>

