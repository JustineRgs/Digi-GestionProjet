<?php

use Formation\MonApp\Model\Taches;

echo '<h2>'.$title.'</h2>';
?>

<!-- Boutton retour accueil -->
<a href='index.php' class="submit_back">< Retour à l'accueil</a>

<!-- Bloc principal -->
<div class="card">
    <h3>Titre du Projet</h3>
    <!-- Bloc principal : Contenu -->
    <div class="contenu">
        <p><?= $project_title ?></p>
        <h3>Liste des tâches</h3>
        <!-- Fonction : récuperer les projets affiliés à son ID -->
        <?php
        foreach ($tasks as $task) {
            if ($task['priorite'] === 'tres_important') {
                $task['priorite'] = 'Très Important';
            }
            if ($task['priorite'] === 'important') {
                $task['priorite'] = 'Important';
            }
            if ($task['priorite'] === 'moins_important') {
                $task['priorite'] = 'Moins Important';
            }
            if ($task['id_projet'] === $_GET['show']) { ?>

                <h4>Titre : <?= $task['task_name'] ?></h4>
                <p>Description : <?= $task['description'] ?></p>
                <p>Priorité : <?= $task['priorite'] ?></p>
                <p>Utilisateur assigné : <?= $task['prenom'].' '.$task['lastname'] ?></p>
                <p>État : <?= $task['etat'] ?></p>
                <?php
                if ($task['prenom'] === $_SESSION['prenom'] && $task['lastname'] === $_SESSION['nom']) {
                    if ($task['id_cycle'] != 3) { ?>
                        <form method="POST">
                            <input type="hidden" name="id_cycle" value="<?= $task['id_cycle'] ?>">
                            <input type="hidden" name="id_taches" value="<?= $task['id_taches'] ?>">
                            <input type="submit" name="changeEtat" class="submit submit--Secondary"
                                   value="<?= Taches::changeEtat($task['id_cycle']); ?>">
                        </form>
                        <?php
                    }
                } ?>
                <?php
            }
        } ?>
    </div>

    <!-- Si on est Admin : on à accés au bouton modifier -->
    <?php
    if ($admin['id_users'] === $_SESSION['id'] && $admin['administrateur'] === '1') { ?>
        <form method="POST" action="">
            <input type="submit" class='submit' name="update_project" value="Modifier le projet">
        </form>
        <?php
    }
    ?>
</div>
    