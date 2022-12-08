<?php
echo '<h2>'.$title.'</h2>';
?>

    <!-- Boutton retour accueil -->
    <a href='index.php?page=project&update=<?php echo $_GET['create_task'] ?>' class="submit_back">< Retour à la
        modification</a>

    <!-- Bloc principal -->
    <div class='card'>
        <!-- Affichage titre de la page à partir de "New View" -->
        <?php
        if (isset($message)) {
            echo '<p>'.$message.'</p>';
        }
        ?>
        <!-- Formulaire : création de la tache -->
        <form method='POST' id="form_task" action="">
            <label for="nom" class="label">Nom de la tache</label>
            <input type='text' name='nom' placeholder='Nom de la tache' required>
            <label for="description" class="label">Description</label>
            <textarea name="description" form="form_task" placeholder='Décrivez la tache en quelques lignes'></textarea>
            <label class="label">Affilier un utilisateur à cette tache</label>
            <select name="user_id" id="user_list" required>
                <option value="" selected hidden disabled>Utilisateurs</option>
                <?php
                foreach ($not_in_project as $users) {
                    echo '<option value="'.$users['id_users'].'">'.$users['prenom'].' '.$users['nom'].' | '.$users['mail'].'</option>';
                } ?>
            </select>
            <label for='priorite' class="label contenu">Priorité</label>
            <div class="radio">
                <input type="radio" name="priorite" value="tres_important"/> Trés important
                <input type="radio" name="priorite" value="important"/> Important
                <input type="radio" name="priorite" value="moins_important"/> Moins important
            </div>
            <input type="submit" name='create' class="sub" value='Créer une tâche'>
        </form>
    </div>
<?php
