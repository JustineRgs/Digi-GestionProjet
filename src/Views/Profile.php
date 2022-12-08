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
        <input type="text" name="nom" class='form_item' value="<?= $_SESSION['nom'] ?>">

        <label for="">Prénom :</label>
        <input type="text" name="prenom" class='form_item' value="<?= $_SESSION['prenom'] ?>">

        <label for="">Adresse e-mail :</label>
        <input type="text" name="mail" class='form_item' value="<?= $_SESSION['mail'] ?>">

        <input type="submit" name="submit" class='submit' value="Modifier">
    </form>
</div>

<!-- Bloc 2 : Mot de passe -->
<div class="card">
    <h3>Changement de mot de passe</h3>
    <?php if (isset($messagepwd)) {
        echo '<p class = "erreur">'.$messagepwd.'</p>';
    } ?>
    <form action="" method="POST">
        <label for="">Mot de passe actuel :</label>
        <input type="password" name="password" class='form_item'>

        <label for="">Nouveau mot de passe :</label>
        <input type="password" name="newpassword" class='form_item'>

        <label for="">Répéter le mot de passe :</label>
        <input type="password" name="newvrfpassword" class='form_item'>

        <input type="submit" name="submitPwd" class='submit' value="Modifier">
    </form>
</div> <!---Formulaire / model / dispatcheur---->

<!-- Bloc 3 : Avatar -->
<div class="card">
    <h3>Votre avatar</h3>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="card_dwl">
            <!-- Fonction : update de l'avatar -->
            <img class="avatar" src="
            <?php
            $avatar = Users::getSession('users', $_SESSION['id']);
            foreach ($avatar[0] as $key => $value) {
                if ($key === 'avatar') {
                    $avatar = $value;
                }
            }
            echo 'upload/'.$_SESSION['id'].'/album/'.$avatar;
            ?>
            " alt="">
            <input type="file" name="file" class='form_item'>
            <!-- Affichage de message à partir de View->SetVar -->
            <?php
            if (isset($message)) {
                echo '<p class = "contenu">'.$message.'</p>';
            }
            ?>
        </div>
        <input type="submit" name="avatar" class='submit' value="Modifier">
    </form>
</div>

<!-- Delete : user -->
<a class='erreur erreur--Secondary btndel' href="index.php?page=&delete=1">Supprimer mon compte</a>

<!-- Fonction : window alert confirmation delete -->
<script type="text/javascript">
  const btn = document.querySelector('.btndel');
  btn.addEventListener('click', function() {
    event.preventDefault();
    var val = confirm('Etes-vous sûr de vouloir supprimer votre compte?');
    if (val == true) {
      window.location = 'index.php?page=&delete=1';
    }
  });
</script>

<!-- Boutton retour accueil -->
<a href='index.php' class="submit_back">< Retour à l'accueil</a>

