<?php
echo '<h2>'.$title.'</h2>';
?>

<!-- Boutton retour accueil -->
<a href='index.php' class="submit_back">< Retour à l'accueil</a>

<!-- Bloc principal -->
<div class='card'>
    <!-- Affichage titre de la page à partir de "New View" -->
    <?php
    if (isset($message)){
        echo '<p>'.$message.'</p>';
    }
    ?>
    <!-- Formulaire : création de la tache -->
    <form method='POST' action="">
        <label for="nom" class="label">Nom de la tache</label> 
        <input type='text' name='nom' placeholder='Nom de la tache' required>
        <label for="description" class="label">Description</label>
        <input type="textarea" name="description" placeholder='Décrivez la tache en quelques lignes'></input>
        <label class="label">Affilier un utilisateur à cette tache</label> 
        <input type='email' name='mail' placeholder="Adresse mail de l'utilisateur" required>
        <label for='priorite' class="label contenu">Priorité</label> 
        <div class="radio">
            <input type="radio" name="priorite" value="tres_important" /> Trés important  
            <input type="radio" name="priorite" value="important" /> Important
            <input type="radio" name="priorite" value="moins_important" /> Moins important  
        </div>
        <input type="submit" name='create' id="sub" value='Créer une tâche'>
    </form>
</div>
<?php
