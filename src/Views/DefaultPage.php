<?php


// Affichage titre de la page à partir de "New View"
if (isset($message)) {
    echo '<h2>'.$message.'</h2>';
}

// Si l'utilisateur n'est pas connecté : formulaire de connexion
if ($connected !== true):
    ?>
    <!-- Bloc principal -->
    <div class="card">
        <!-- Formulaire de connexion -->
        <form method='POST' action=''>
            <label for="">Adresse e-mail :</label>
            <input type='text' method="POST" name='mail' class='form_item' placeholder='Adresse e-mail'>
            <label for="">Mot de passe :</label>
            <input type='password' name='pwd' class='form_item' placeholder="*********">
            <input type='submit' name='connect' class='submit' value='Se connecter'>
        </form>

        <!-- S'il n'as pas de compte : redirection vers create_user -->
        <div class='add_user_project'>
            <p class='compte'>Vous n'avez pas de compte? </p>
            <a href='index.php?page=profile&user=register'>Créer un Compte</a>
        </div>
    </div>

<?php

// Si il est connecté : 
else:
    echo '<h2>'.$title.'</h2>';
    ?>
    <!-- Bloc principal : bloc PROJET et bloc TACHES-->
    <div class="card_pack">
        <!-- Bloc 1 : Projet -->
        <div class="card card--Secondary">
            <h3>Vos projets</h3>
            <table>
                <?php
                // Si le tableau affect est vide
                if (count($affec) === 0) {
                    echo "<p class='erreur'>Vous n'avez pas encore de projet !</p>";
                } else {
                    foreach ($affec as $projet => $key) { //affec : tableaux des projets en lien à l'ID connecté
                        foreach ($key as $k => $v) {
                            if ($k === 'nom') {
                                ?>
                                <tr>
                                    <td></td>
                                </tr>

                                <!-- Nom du projet -->
                                <tr class="ligne">
                                    <th colspan="2"><a
                                                href="index.php?page=project&show=<?= $key['id_projet'] ?>"><?= $v ?></a>
                                    </th>
                                </tr>

                                <?php
                                // Si l'utilisateur est admin : il à accés au boutton suppr et modif
                                if ($key['administrateur'] === 1) {
                                    ?>
                                    <tr class="ligne">
                                        <!-- Redirection : Modifier le projet -->
                                        <td>
                                            <a href="index.php?page=project&update=<?= $key['id_projet'] ?>">Modifier</a>
                                        </td>
                                        <!-- Suppression du projet -->
                                        <td class="ligne_delete"><a
                                                    href="index.php?page=project&delete=<?= $key['id_projet'] ?>">
                                                <ion-icon name="trash-outline"></ion-icon>
                                            </a></td>
                                        <!-- Fonction : window alert confirmation delete -->
                                        <script type="text/javascript">
                                          const btn = document.querySelector('.ligne_delete');
                                          btn.addEventListener('click', function() {
                                            event.preventDefault();
                                            var val = confirm('Etes-vous sûr de vouloir supprimer ce projet?');
                                            if (val == true) {
                                              window.location = "index.php?page=project&delete=<?= $key['id_projet']?>";
                                            }
                                          });
                                        </script>
                                    </tr>
                                    <?php
                                } ?>
                                <?php
                            }
                        }
                    }
                }
                ?>
            </table>
            <!-- Boutton : créer un nouveau projet -->
            <form method='POST' action='index.php?page=project&create'>
                <input type='submit' name='submit' class='submit' value="Nouveau projet !">
            </form>
        </div>

        <!-- Bloc 2 : Tâches -->
        <div class="card card--Secondary">
            <h3>Vos tâches</h3>
            <?php
            // Si le tableau tache est vide
            if (count($tasks) === 0) {
                echo "<p class='erreur'>Vous n'avez pas encore de tâches!</p>";
            } else {
                foreach ($tasks as $task) {
                    foreach ($affec as $projet => $key) {
                        // Si une tache est affilié à son ID alors elle est affiché
                        if ($task['id_projet'] === $key['id_projet'] && $task['id_users'] === $_SESSION['id']) {
                            ?>
                            <table>
                                <tr class="ligne">
                                    <th class="task">Projet</th>
                                    <th class="task">Nom de la tache</th>
                                    <th class="task">Description</th>
                                    <th class="task">Priorité</th>
                                    <th class="task">Etat</th>
                                </tr>

                                <tr class="ligne">
                                    <td class="task"><a
                                                href="index.php?page=project&show=<?= $key['id_projet'] ?>"><?= $key['nom'] ?></a>
                                    </td>
                                    <td class="task"><?= $task['task_name'] ?></td>
                                    <td class="task"><?= $task['description'] ?></td>

                                    <td class="task"><?php
                                        if ($task['priorite'] === 'tres_important') {
                                            echo '<p id="t_important">Trés important !</p>';
                                        }
                                        if ($task['priorite'] === 'important') {
                                            echo '<p id="p_important">Peu important</p>';
                                        }
                                        if ($task['priorite'] === 'moins_important') {
                                            echo '<p id="important">Important</p>';
                                        }
                                        ?>
                                    </td>
                                    <td class="task"><?= $task['etat'] ?></td>
                                </tr>

                            </table>
                            <?php
                        }
                    }
                }
            }
            ?>
        </div>
    </div>
<?php endif;
?>