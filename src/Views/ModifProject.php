<?php
echo '<h2>'.$title.'</h2>';
?>
<a href='index.php' class="submit_back">< Retour à l'accueil</a>
<div class="card">
<?php
    if (isset($message)){
        echo '<p class="erreur">'.$message.'</p>';
    }
    ?>

    <form method='POST' action=''>
        <input type='text' name='ProjectName' class= 'form_item' placeholder='Nom du projet' required>
        <!-- <input type='submit' name='SubmitTask' class= 'form_item' value="Ajouter une tache"> -->
        <input type='submit' name='submitPro' class = 'submit' value="Modfifier">
    </form>
</div>