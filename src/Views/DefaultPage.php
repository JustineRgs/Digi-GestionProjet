<?php
use Formation\MonApp\Model\Users;
use Formation\MonApp\Model\Projets;

if (isset($message)) {
    echo '<h2>'.$message.'</h2>';
}

if ($connected !== true):
    ?>
    <div class="card">
        <form method='POST' action=''>
            <label for="">Adresse e-mail :</label>
            <input type='text' method="POST" name='mail' class= 'form_item' placeholder='Adresse e-mail'>
            <label for="">Mot de passe :</label>
            <input type='password' name='pwd' class= 'form_item' placeholder="*********">
            <input type='submit' name='connect' class = 'submit' value='Se connecter'>
        </form>
        
        <div class='add_count'>
            <p class='compte'>Vous n'avez pas de compte? </p>
            <a href='index.php?page=profile&user=register'>Créer un Compte</a>
        </div>
    </div>
  
<?php 
else:
    echo '<h2>'.$title.'</h2>';
?>

    <div class="card_pack">
        <div class="card card--Secondary">
            <h3>Vos projets</h3>
            <table>
                <?php 
                if (count($affec)===0) {
                    echo "<p class='erreur'>Vous n'avez pas encore de projet !</p>";
                } else {
                    foreach($affec as $projet => $key){ //affec : tableaux des projets en lien à l'ID connecté
                        foreach($key as $k => $v){
                            if ($k === 'nom'){
                                ?>
                                <tr class="ligne">
                                <th><a href="index.php?page=project&show=<?= $key['id_projet']?>"><?= $v ?></a></th> <!--- intitulé formation --->
                                
                                <?php if ($key['administrateur'] === '1'){?>
                                    <td><a href="index.php?page=project&update=<?= $key['id_projet']?>">Modifier</a></td>
                                    <td class="ligne_delete"><a href="index.php?page=project&delete=<?= $key['id_projet']?>"><ion-icon name="trash-outline"></ion-icon></a></td>
                            <?php }?>
                                </tr>
                                <?php
                            } 
                        }
                    }
                }
                ?>
            </table>

            <form method='POST' action='index.php?page=project&create'>
                <input type='submit' name='submit' class = 'submit' value="Nouveau projet !">            
            </form>
        </div>

        <div class="card card--Secondary">
            <h3>Vos tâches</h3>
            <?php
            foreach ($tasks as $task){
                if(!$task['id_users'] === $_SESSION['id']){
                    echo 'Vous n\'avez pas de tâches';
                }else{                  
                    foreach($affec as $projet => $key){
                        if ($task['id_projet'] === $key['id_projet'] && $task['id_users'] === $_SESSION['id']){
                            ?>
                            <table>  
                                <tr class="ligne">
                                    <th>Titre</th>
                                    <th>Description</th>
                                    <th>Projet</th>
                                    <th>Priorité</th>
                                </tr>

                                <tr class="ligne">
                                    <td><?= $task['task_name'] ?></td>
                                    <td><?= $task['description'] ?></td>
                                    <td><?= $key['nom'] ?></td>
                                    <td><?php 
                                        if ($task['priorite'] === 'tres_important') {
                                            echo '<p id="t_important">Trés important !</p>';
                                        }
                                        if ($task['priorite'] === 'important') {
                                            echo '<p id="important">Important</p>';
                                        }
                                        if ($task['priorite'] === 'moins_important') {
                                            echo '<p id="p_important">Peu important</p>';
                                        }
                                    ?>
                                    </td>                          
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