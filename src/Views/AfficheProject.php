<?php
echo '<h2>'.$title.'</h2>';
?>
<a href='index.php' class="submit_back">< Retour à l'accueil</a>
<div class="card">


<h3>Titre du Projet</h3>
<p><?php echo $project_title?></p>
<h3>Liste des tâches</h3>
<?php foreach ($tasks as $task){ if ($task['id_projet'] === $_GET['show']){?>
    <div>
    <h4>Titre: <?php echo $task['task_name'] ?></h4>
    <p>Description: <?php echo $task['description'] ?></p>
    <p>Priorité: <?php echo $task['priorite'] ?></p>
    <p>Utilisateur assigné: <?php echo $task['prenom'].' '.$task['lastname'] ?></p>
    <p>État: <?php echo $task['etat']?></p>
</div>
<?php }}?>

<form method="POST" action="index.php?page=project&create_task=<?php echo $_GET['show']?>">
    <input type="submit" class='submit' value="Créer une tâche">
</form>
    