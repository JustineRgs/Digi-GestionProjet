<?php
echo '<h2>'.$title.'</h2>';
?>

<!-- Boutton retour : page de connexion -->
<a href='index.php' class="submit_back">< J'ai déjà un compte</a>

<!-- Formulaire : Création d'un utilisateur -->
<div class="card">
    <form method='POST'>
        <input type='text' name='nom' class= 'form_item' placeholder='Votre nom'>
        <input type='text' name='prenom' class= 'form_item' placeholder='Votre prenom'>
        <input type='email' name='mail' class= 'form_item' placeholder='Votre mail'>
        <input type='password' name='pwd' class= 'form_item' placeholder='Votre mot de passe'>
        <input type='password' name='confirmpwd' class= 'form_item' placeholder='Confirmez le mot de passe'>
        <input type="hidden" name="avatar" class= 'form_item' value="">
        <input type='submit' name='create' class = 'submit' value="Enregistrer">
    </form>
</div>