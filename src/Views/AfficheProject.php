<?php

use Formation\MonApp\Model\Taches;

echo '<h2>'.$title.'</h2>';
?>
<a href='index.php' class="submit_back">< Retour à l'accueil</a>
<div class="card">


<h3>Titre du Projet</h3>
<p><?= $project_title?></p>
<h3>Liste des tâches</h3>


<?php foreach ($tasks as $task){ 
    if ($task['id_projet'] === $_GET['show']){?>
    <div>
    <h4>Titre: <?= $task['task_name'] ?></h4>
    <p>Description: <?= $task['description'] ?></p>
    <p>Priorité: <?= $task['priorite'] ?></p>
    <p>Utilisateur assigné: <?= $task['prenom'].' '.$task['lastname'] ?></p>
    <p>État: <?= $task['etat']?></p>
<?php if ($task['id_cycle'] != 3){?>
    <form method="POST" action="">
    <input type="hidden" name="id_cycle" value="<?= $task['id_cycle']?>">
    <input type="hidden" name="id_taches" value="<?= $task['id_taches']?>">
    <input type="submit" name="changeEtat" value="<?= Taches::changeEtat($task['id_cycle']);?>">
</form>
<?php }?>
</div>
<?php }}?>

<?php if ($admin['id_users'] === $_SESSION['id'] && $admin['administrateur'] === '1'){?>
    <form method="POST" action="">
    <input type="submit" class='submit' name="update_project" value="Modifier le projet">
</form>

<?php }?>
    