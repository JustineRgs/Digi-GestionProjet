<?php

echo '<h2>'.$title.'</h2>';
?>

<!-- Boutton retour accueil -->
<a href='index.php?page=project&show=<?php echo $_GET['update'] ?>' class="submit_back">< Retour au projet</a>

<!-- Partie 1 : Nom du projet -->
<div class="card">
    <?php
    if (isset($message)) {
        echo '<p class="erreur">'.$message.'</p>';
    } ?>

    <h3>Nom du projet</h3>
    <form method='POST' action=''>
        <input type='text' name='ProjectName' class='form_item' placeholder='Nom du projet' value="<?= $project_name ?>"
               required>
        <input type='submit' name='update_project_name' class='submit' value="Modifier">
    </form>
</div>

<!-- Partie 2 : Liste des utilisateurs affiliés -->
<div class="card">
    <h3>Liste des utilisateurs affiliés à ce projet</h3>
    <?php
    foreach ($in_project as $users) { ?>
        <div class="ul_user">
            <?php echo $users['prenom'].' '.$users['nom']; ?>
            <a href="index.php?deleteU=<?php echo $users['id_users'] ?>&pagemodif=<?php echo $_GET['update'] ?>">Supprimer</a>
        </div>
        <?php
    } ?>

    <!-- Ajouter un utilisateur au projet -->
    <div class="add_users">
        <!-- Utilisateurs existants -->
        <div class="card_content">
            <p class="contenu"><b>Ajouter un utilisateur existant :</b></p>
            <form method="POST" action="">
                <select name="user_id" id="user_list" required>
                    <option value="" selected hidden disabled>Utilisateurs</option>
                    <?php
                    foreach ($not_in_project as $users) {
                        echo '<option value="'.$users['id_users'].'">'.$users['prenom'].' '.$users['nom'].' | '.$users['mail'].'</option>';
                    } ?>
                </select>
                <input type="submit" name="add_user" class='submit' value="Ajouter">
            </form>
        </div>

        <!-- Ou créer un nouvel utilisateur -->
        <div class="card_content">
            <p class="contenu"><b>Ajouter un nouvel utilisateur :</b></p>
            <form method="POST" action="">
                <input type="submit" name="create_user" class='submit' value="Créer">
            </form>
        </div>
    </div>
</div>

<!-- Partie 3 : Liste des tâches -->
<div class="card">
    <h3>Liste des tâches</h3>
    <?php
    foreach ($tasks as $task) {
        if ($task['id_projet'] === $_GET['update']) { ?>
            <form method="POST" id="edit_task_form" class="form--Secondary" action="">
                <table class="table_task">

                    <tr class="ligne">
                        <td class="ligne">Priorité</td>
                        <td class="ligne">Titre</td>
                    </tr>

                    <tr class="ligne">
                        <td><select name="priorite">
                                <?php
                                if ($task['priorite'] === 'tres_important') {
                                    ?>
                                    <option value="tres_important" selected>Très important</option>
                                    <option value="important">Important</option>
                                    <option value="moins_important">Moins important</option>
                                <?php } else {
                                    if ($task['priorite'] === 'important') { ?>
                                        <option value="tres_important">Très important</option>
                                        <option value="important" selected>Important</option>
                                        <option value="moins_important">Moins important</option>
                                    <?php } else { ?>
                                        <option value="tres_important">Très important</option>
                                        <option value="important">Important</option>
                                        <option value="moins_important" selected>Moins important</option>
                                    <?php }
                                } ?>
                            </select></td>
                        <td><input type="text" name="titre" value=<?= $task['task_name'] ?>></td>

                    </tr>
                    <tr>
                        <td></td>
                    </tr>


                    <tr class="ligne">
                        <td class="ligne">Description</td>
                        <td class="ligne">Utilisateur assigné</td>
                    </tr>

                    <tr>
                        <td class="ligne"><textarea name="description"
                                                    form="form_task"><?= $task['description'] ?></textarea></td>
                        <td class="ligne"><select name="user_id" id="user_list">
                                <?php foreach ($in_project as $users) {
                                    $selected = '';
                                    if ($users['id_users'] === $task['id_users']) {
                                        $selected = ' selected';
                                    }
                                    echo '<option value="'.$users['id_users'].'"'.$selected.'>'.$users['prenom'].' '.$users['nom'].' | '.$users['mail'].'</option>';
                                }
                                ?>
                            </select></td>
                    </tr>
                </table>
                <div class="modif">
                    <input type='submit' name='update_task' class='submit submit--Secondary' value="Modifier">
                    <input type="hidden" name="task_id" value="<?= $task['id_taches'] ?>">
                    <input type="hidden" name="projet_id" value="<?= $task['id_projet'] ?>">
                    <input type="submit" name="deleteTask" class="submit submit--Secondary submit-Ter"
                           value="Supprimer"> <!---Redirige vers ProjectController--->
                </div>
            </form>
            <?php
            if ($task['id_cycle'] != 3) { ?>
                <form method="POST" action="">
                    <input type="hidden" name="id_cycle" value="<?= $task['id_cycle'] ?>">
                    <input type="hidden" name="id_taches" value="<?= $task['id_taches'] ?>">
                </form>
                <?php
            } ?>
            <?php
        }
    } ?>
    <form method="POST" action=""><input type="submit" class='submit' name="create_task" value="Créer une tâche"></form>
</div>
