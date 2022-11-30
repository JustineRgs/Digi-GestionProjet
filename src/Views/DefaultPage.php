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
    <!-- <form method="POST" action='http://localhost/GestionProjet/index.php?page=profile&user=register">
        <input type='submit' name='show' class = 'submit' value='Créer un Compte'>
    </form> -->
</div>

<?php else:
echo '<h2>'.$title.'</h2>';
?>
<div class="card_pack">
    <div class="card card--Secondary">
        <h3>Vos projets</h3>
        <table>
        <?php 
            foreach($affec as $projet => $key){ //affec : tableaux des projets en lien à l'ID connecté
                foreach($key as $k => $v){
                    if ($k === 'nom'){
                    ?>
                        <tr class="ligne">
                            <th><a href="index.php?page=project&show=<?php echo $key['id_projet']?>"><?php echo $v ?></a></th> <!--- intitulé formation --->
                            <td><a href="index.php?page=project&update=<?php echo $key['id_projet']?>">Modifier</a></td>
                            <td class="ligne_delete"><a href="index.php?page=project&delete=<?php echo $key['id_projet']?>"><ion-icon name="trash-outline"></ion-icon></a></td>
                        </tr>
                    <?php
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
        foreach ($tasks as $task){ // Pas l'impression que ca marche
            if(!$task['id_users'] === $_SESSION['id']){
                ?>
                    <p>Vous n'avez pas de pages</p>
                <?php
            }else{
                ?>
                <table>
                    <tr>
                        <td><h4>Titre: <?php echo $task['task_name'] ?></h4></td>
                        <td><p>Description: <?php echo $task['description'] ?></p></td>
                        <td><p>Priorité: <?php echo $task['priorite'] ?></p></td>
                    </tr>
                </table>
                <?php 
            }
            
        }
        ?>
    </div>
</div>

<?php endif; 
?>