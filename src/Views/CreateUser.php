<?php
echo '<h2>'.$title.'</h2>';
if (isset($message)) {
    echo '<div>'.$message.'</div>';
}
?>

<form method='POST' action=''>
    <input type='text' name='nom' placeholder='Votre nom'>
    <input type='text' name='prenom' placeholder='Votre prenom'>
    <input type='email' name='mail' placeholder='Votre mail'>
    <input type='password' name='pwd' placeholder='Votre mot de passe'>
    <input type='password' name='confirmpwd' placeholder='Confirmez le mot de passe'>
    <input type='submit' name='create' class = 'submit' value="enregistrer">
</form>