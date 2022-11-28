<h1>
    <?php echo $message; ?>
    
</h1>
<!-- <p>
    <?php echo $main; ?>
</p> -->
<?php
    if ($connected !== true):
?>
<form method='POST' action=''>
    <input type='text' method="POST" name='mail' placeholder='Votre email'>
    <input type='password' name='pwd' placeholder="Votre mot de passe">
    <input type='submit' name='connect' value='Se connecter'>
</form>

<p class='compte'>Vous n'avez pas de compte? </p>
<form method="POST" action='http://localhost/GestionProjet/index.php?page=profile&user=register'>
    <input type='submit' name='show' value='Créer un Compte'>
</form>
<?php else:

echo '<h2>'.$title.'</h2>';

foreach($pro as $user => $key){
    foreach($key as $k=>$l){
        
?>
<table>
    <tr>
        <th><?php echo $k ?></th>
    </tr>
    <tr>
        <td><?php echo $l ?></td>
    </tr>
</table>

<?php
    }
}
?>
<form method='POST' action='index.php?page=createproject'>
    <input type='submit' name='submit' value="Créer un nouveau projet">
</form>
<?php endif; ?>