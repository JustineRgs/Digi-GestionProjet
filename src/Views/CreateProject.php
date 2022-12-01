<?php

echo '<h2>'.$title.'</h2>';
?>
<!-- Boutton retour accueil -->
<a href='index.php' class="submit_back">< Retour à l'accueil</a>

<!-- Bloc principal -->
<div class="card">
    <!-- Affichage titre de la page à partir de "New View" -->
    <?php
    if (isset($message)){
        echo '<p class="erreur">'.$message.'</p>';
    }
    ?>
    <!-- Ajouter un titre à son projet -->
    <form method='POST' action=''>
        <label>Ajouter un nom à votre projet</label>
        <input type='text' name='ProjectName' class= 'form_item' placeholder='Nom du projet' required>
        <input type='submit' name='submitPro' class = 'submit' value="Créer">
    </form>    
</div>