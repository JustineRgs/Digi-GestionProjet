<?php
echo '<h2>'.$title.'</h2>';
?>

<a href='index.php' class="submit_back">< Retour à l'accueil</a>
<div class='card'>
    <?php
    if (isset($message)){
        echo '<p>'.$message.'</p>';
    }
    ?>
    <form method='POST' action="">
        <label for="nom">Nom de la tache</label> 
        <input type='text' name='nom' placeholder='Nom de la tache' required>
        <label for='priorite'>Priorité</label> 
        <input type="radio" name="priorite" value="tres_important" /> Trés important
        <input type="radio" name="priorite" value="important" /> Important
        <input type="radio" name="priorite" value="moins_important" /> Moins important
        <label for="description">Description</label>
        <input type="text" name="description" id="description">
        <!-- <textarea name="description" placeholder='Décrivez la tache en quelques lignes'></textarea> N'est pas un type input et donc fait buguer l'insert en bdd  -->
        <label>Affilier un utilisateur à cette tache</label> 
        <input type='email' name='mail' required>
        <input type="submit" name='create' value='Créer une tâche'>
    </form>
</div>
<?php
