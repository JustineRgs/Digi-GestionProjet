<?php
use Formation\MonApp\Model\Taches;
echo '<h2>'.$title.'</h2>';
?>

<a href='index.php' class="submit_back">< Retour à l'accueil</a>
<div class="card">
<?php
    if (isset($message)){
        echo '<p class="erreur">'.$message.'</p>';
    }
    ?>

    <h3>Nom du projet</h3>
    <form method='POST' action=''>
        <input type='text' name='ProjectName' class='form_item' placeholder='Nom du projet' value="<?= $project_name?>" required> 
    </form>
</div>
<div class="card">
    <h3>Liste des utilisateurs affilié à ce projet</h3>
    <?php foreach($in_project as $users){
        ?> 
        <div class="ul_user">
            <?php echo $users['prenom'].' '.$users['nom'];?>    
            <p>   </p>
            <a href="index.php?deleteU=<?php echo $users['id_users'] ?>&pagemodif=<?php echo $_GET['update'] ?>">Supprimer</a> 
        </div>    
    <?php 
    } ?>

    <form method="POST" action="">
        <select name="user_id" id="user_list">
            <option value="">Ajouter un utilisateur</option>
            <?php foreach($not_in_project as $users){
                echo '<option value="'.$users['id_users'].'">'.$users['prenom'].' '.$users['nom'].'</option>';
            }
            ?>
        </select>
        <input type="submit" name="add_user" class = 'submit' value="Ajouter">
        <input type="submit" name="create_user" class = 'submit' value="Créer">
    </form>  
</div>

<div class="card">
    <h3>Liste des tâches</h3>


<?php foreach ($tasks as $task){ 
    if ($task['id_projet'] === $_GET['update']){?>
    <div>
        <form method="POST" action="">
            <table>                
                <tr class="ligne">
                    <td>Priorité</td>
                    <td>Titre</td>
                    <td>Description</td>
                    <td>Utilisateur assigné</td> 
                </tr>

                <tr class="ligne">
                    <td><select name="priorite"><option value=<?= $task['priorite'] ?>></option>
                        <option value="tres_important">Très important</option>
                        <option value="important">Important</option>
                        <option value="moins_important">Moins important</option></td>
                    <td><input type="text" name="titre" value=<?= $task['task_name'] ?>></h4></td>
                    <td><input type="text" name="description" value=<?= $task['description'] ?>></td>
                    <td><select name="user_id" id="user_list"><option value="">Ajouter un utilisateur</option>
                        <?php foreach($not_in_project as $users){
                            echo '<option value="'.$users['id_users'].'">'.$users['prenom'].' '.$users['nom'].'</option>';
                            }           
                        ?>
                        </select></td>
                </tr>               
            </table>
                <input type='submit' name='submitPro' class = 'submit' value="Modifier">
        </form>
<?php if ($task['id_cycle'] != 3){?>
    <form method="POST" action="">
    <input type="hidden" name="id_cycle" value="<?= $task['id_cycle']?>">
    <input type="hidden" name="id_taches" value="<?= $task['id_taches']?>">
</form>
<?php }?>
</div>
<?php }}?>
<form method="POST" action=""><input type="submit" class='submit' name="create_task" value="Créer une tâche"></form>
